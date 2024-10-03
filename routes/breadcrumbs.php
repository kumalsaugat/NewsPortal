<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard Breadcrumb
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dynamic News Index Breadcrumb
Breadcrumbs::for('news.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard'); // Assuming 'dashboard' is already defined
    $trail->push('News', route('news.index'));
});

// Dynamic Create News Breadcrumb
Breadcrumbs::for('news.create', function (BreadcrumbTrail $trail) {
    $trail->parent('news.index');
    $trail->push('Create News', route('news.create'));
});

// Dynamic Edit News Breadcrumb
Breadcrumbs::for('news.edit', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news.index');
    $trail->push('Edit ' . ($news->title ? ' / ' . $news->title : ''),  route('news.edit', $news->id));
});

// Dynamic Show Single News Breadcrumb
Breadcrumbs::for('news.show', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news.index');
    $trail->push('View ' . ($news->title ? ' / ' . $news->title : ''),  route('news.show', $news->id));

});

// Category Index Breadcrumb
Breadcrumbs::for('news-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Category', route('news-category.index'));
});

// Create Category Breadcrumb
Breadcrumbs::for('news-category.create', function (BreadcrumbTrail $trail) {
    $trail->parent('news-category.index');
    $trail->push('Create Category', route('news-category.create'));
});

// Edit Category Breadcrumb
Breadcrumbs::for('news-category.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('news-category.index');
    $trail->push('Edit '. ($category->name ? ' / ' . $category->name : ''), route('news-category.edit', $category->id));

});

// Show Category Breadcrumb
Breadcrumbs::for('news-category.show', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('news-category.index');
    $trail->push('View '. ($category->name ? ' / ' . $category->name : ''), route('news-category.show', $category->id));

});

// User Index Breadcrumb
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('user.index'));
});

// Create User Breadcrumb
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.index');
    $trail->push('Create User', route('user.create'));
});

// Edit User Breadcrumb
Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('Edit '. ($user->name ? ' / ' . $user->name : ''), route('user.edit', $user->id));
});

// Show User Breadcrumb
Breadcrumbs::for('user.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('View '. ($user->name ? ' / ' . $user->name : ''), route('user.show', $user->id));
});

Breadcrumbs::for('user-update', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('Update/'.$user->name, route('user.update', $user));
});
