<?php

namespace App\Services\Admin;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public function getAll(array $filters = [])
    {
        return Expense::query()
            ->with('category', 'creator')
            ->when($filters['category_id'] ?? null, fn ($q, $v) => $q->where('expense_category_id', $v))
            ->when($filters['payment_method'] ?? null, fn ($q, $v) => $q->where('payment_method', $v))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('expense_date', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('expense_date', '<=', $v))
            ->when($filters['search'] ?? null, function ($q, $v) {
                $q->where(function ($q2) use ($v) {
                    $q2->where('expense_no', 'like', "%{$v}%")
                       ->orWhere('title', 'like', "%{$v}%");
                });
            })
            ->latest('expense_date')
            ->paginate(20)
            ->withQueryString();
    }

    public function getCreateData(): array
    {
        return ['categories' => ExpenseCategory::active()->orderBy('name')->get()];
    }

    public function getEditData(string $id): array
    {
        return [
            'expense'    => Expense::findOrFail($id),
            'categories' => ExpenseCategory::active()->orderBy('name')->get(),
        ];
    }

    public function getTrashed()
    {
        return Expense::onlyTrashed()->with('category')->get();
    }

    public function store($request): Expense
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            if ($request->hasFile('attachment')) {
                $data['attachment'] = $this->uploadAttachment($request->file('attachment'));
            }

            $data['expense_no'] = $this->generateExpenseNumber();
            $data['created_by'] = $this->resolveCreatedBy();

            return Expense::create($data);
        });
    }

    public function update($request, string $id): Expense
    {
        return DB::transaction(function () use ($request, $id) {
            $expense = Expense::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('attachment')) {
                if ($expense->attachment) {
                    Storage::disk('public')->delete($expense->attachment);
                }
                $data['attachment'] = $this->uploadAttachment($request->file('attachment'));
            }

            $expense->update($data);
            return $expense;
        });
    }

    public function delete(string $id): void
    {
        Expense::findOrFail($id)->delete();
    }

    public function restore(string $id): void
    {
        Expense::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(string $id): void
    {
        $expense = Expense::withTrashed()->findOrFail($id);

        if ($expense->attachment) {
            Storage::disk('public')->delete($expense->attachment);
        }

        $expense->forceDelete();
    }

    /* =========================
       HELPERS
    ==========================*/

    protected function uploadAttachment($file): string
    {
        $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('expenses', $name, 'public');
    }

    protected function generateExpenseNumber(): string
    {
        $date = now()->format('Ymd');
        do {
            $count = Expense::withTrashed()->whereDate('created_at', now())->count() + 1;
            $candidate = "EXP-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
            $exists = Expense::withTrashed()->where('expense_no', $candidate)->exists();
        } while ($exists);

        return $candidate;
    }

    protected function resolveCreatedBy(): ?int
    {
        $id = Auth::guard('admin')->id();
        return $id && Admin::where('id', $id)->exists() ? $id : null;
    }
}