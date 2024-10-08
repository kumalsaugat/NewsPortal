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
    $trail->parent('news.show', $news);
    $trail->push('Edit', route('news.edit', $news));
});

// Dynamic Show Single News Breadcrumb
Breadcrumbs::for('news.show', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news.index');
    $trail->push($news->title, route('news.show', $news->id));
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
    $trail->parent('news-category.show', $category);
    $trail->push('Edit', route('news-category.edit', $category));
});

// Show Category Breadcrumb
Breadcrumbs::for('news-category.show', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('news-category.index');
    $trail->push($category->name, route('news-category.show', $category->id));
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
    $trail->parent('user.show',$user);
    $trail->push('Edit', route('user.edit', $user));
});

// Show User Breadcrumb
Breadcrumbs::for('user.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push($user->name, route('user.show', $user->id));
});

// Update Password User
Breadcrumbs::for('user-update', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.show', $user);
    $trail->push('Edit', route('user.update', $user));
});

// Album Index Breadcrumb
Breadcrumbs::for('album.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Albums', route('album.index'));
});

// Create Album Breadcrumb
Breadcrumbs::for('album.create', function (BreadcrumbTrail $trail) {
    $trail->parent('album.index');
    $trail->push('Create Album', route('album.create'));
});

// Edit Album Breadcrumb
Breadcrumbs::for('album.edit', function (BreadcrumbTrail $trail, $album) {
    $trail->parent('album.show', $album);
    $trail->push('Edit', route('album.edit', $album));
});

// Show Album Breadcrumb
Breadcrumbs::for('album.show', function (BreadcrumbTrail $trail, $album) {
    $trail->parent('album.index');
    $trail->push($album->title, route('album.show', $album->id));
});

// Album Image Index Breadcrumb
Breadcrumbs::for('album-image.index', function (BreadcrumbTrail $trail) {
    $trail->parent('album.index');
    $trail->push('Album Images', route('album-image.index'));
});
