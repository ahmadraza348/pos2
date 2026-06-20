<?php

use Illuminate\Support\Facades\Gate;

Gate::define(
    'category.view',
    fn($user) =>
    $user->hasRole(['admin', 'manager', 'viewer'])
);

Gate::define(
    'category.create',
    fn($user) =>
    $user->hasRole(['admin'])
);

Gate::define(
    'category.update',
    fn($user) =>
    $user->hasRole(['admin', 'manager'])
);

Gate::define(
    'category.delete',
    fn($user) =>
    $user->hasRole('admin')
);

Gate::define(
    'category.bulkDelete',
    fn($user) =>
    $user->hasRole('admin')
);
