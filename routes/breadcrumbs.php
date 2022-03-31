<?php

use App\Models\Entry;
use App\Models\Product;
use App\Models\Room;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('system.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('system.dashboard'));
});


// ===> ENTRADAS <==============================================================

// Dashboard > Entradas > [Quarto]
Breadcrumbs::for('system.entries.room.create', function (BreadcrumbTrail $trail, Room $room) {
    $trail->parent('system.dashboard');
    $trail->push('Quarto ' . $room->number, null);
});

// Dashboard > Entradas > [Quarto] > Criar
Breadcrumbs::for('system.entries.create', function (BreadcrumbTrail $trail, Room $room) {
    $trail->parent('system.entries.room.create', $room);
    $trail->push('Cadastrar entrada');
});

// Dashboard > Entradas > Editar > [Quarto]
Breadcrumbs::for('system.entries.room.edit', function (BreadcrumbTrail $trail, Entry $entry) {
    $trail->parent('system.dashboard');
    $trail->push('Quarto ' . $entry->room->number, null);
});

// Dashboard > Entradas > Editar > [Quarto] > [Entrada]
Breadcrumbs::for('system.entries.edit', function (BreadcrumbTrail $trail, Entry $entry) {
    $trail->parent('system.entries.room.edit', $entry);
    $trail->push('Editar entrada do horário: ' . datetime_to_br($entry->entry_time));
});


// ===> USUARIOS <==============================================================

// Dashboard > Usuários
Breadcrumbs::for('system.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('system.dashboard');
    $trail->push('Usuários', route('system.users.index'));
});

// Dashboard > Usuários > Criar
Breadcrumbs::for('system.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('system.users.index');
    $trail->push('Adicionar', route('system.users.create'));
});

// Dashboard > Usuários > Editar > [Usuário]
Breadcrumbs::for('system.users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('system.users.index');
    $trail->push($user->name, route('system.users.edit', $user));
});

// Dashboard > Usuários > Visualizando > [Usuário]
Breadcrumbs::for('system.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('system.users.index');
    $trail->push($user->name, route('system.users.show', $user));
});


// ===> PRODUTOS <==============================================================

// Dashboard > Produtos
Breadcrumbs::for('system.products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('system.dashboard');
    $trail->push('Produtos', route('system.products.index'));
});

// Dashboard > Produtos > Criar
Breadcrumbs::for('system.products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('system.products.index');
    $trail->push('Adicionar', route('system.products.create'));
});

// Dashboard > Produtos > Editar > [Produto]
Breadcrumbs::for('system.products.edit', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('system.products.index');
    $trail->push($product->name, route('system.products.edit', $product));
});

// Dashboard > Produtos > Visualizando > [Produto]
Breadcrumbs::for('system.products.show', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('system.products.index');
    $trail->push($product->name, route('system.products.show', $product));
});

// Dashboard > Produtos > Incrementar estoque
Breadcrumbs::for('system.products.increment-quantity.index', function (BreadcrumbTrail $trail) {
    $trail->parent('system.products.index');
    $trail->push('Incrementar estoque', route('system.products.increment-quantity.index'));
});


// ===> QUARTOS <===============================================================

// Dashboard > Quartos
Breadcrumbs::for('system.rooms.index', function (BreadcrumbTrail $trail) {
    $trail->parent('system.dashboard');
    $trail->push('Quartos', route('system.rooms.index'));
});

// Dashboard > Quartos > Criar
Breadcrumbs::for('system.rooms.create', function (BreadcrumbTrail $trail) {
    $trail->parent('system.rooms.index');
    $trail->push('Adicionar', route('system.rooms.create'));
});

// Dashboard > Quartos > Editar > [Produto]
Breadcrumbs::for('system.rooms.edit', function (BreadcrumbTrail $trail, Room $room) {
    $trail->parent('system.rooms.index');
    $trail->push($room->number, route('system.rooms.edit', $room));
});

// Dashboard > Quartos > Visualizando > [Quarto]
Breadcrumbs::for('system.rooms.show', function (BreadcrumbTrail $trail, Room $room) {
    $trail->parent('system.rooms.index');
    $trail->push($room->number, route('system.rooms.show', $room));
});

// Dashboard > Quartos > Alterar preço hora adicional
Breadcrumbs::for('system.rooms.edit-price-per-additional-hour', function (BreadcrumbTrail $trail) {
    $trail->parent('system.rooms.index');
    $trail->push('Alterar preço hora adicional', route('system.rooms.edit-price-per-additional-hour'));
});
