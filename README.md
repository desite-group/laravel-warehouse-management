# Laravel Nova UA Volunteers Warehouse Management
A simple package for an online store, for managing orders and warehouse. Based on Laravel Nova

# Installation

You can install the package via composer:

    composer require desite-group/laravel-nova-ua-volunteers-warehouse-management

After that, you need to run migrations.

    php artisan migrate
You can publish translates

    php artisan vendor:publish --tag=volunteers-warehouse-seeds

You can seed checkpoints

    php artisan db:seed --class=VolunteersWarehouseCheckpointsSeeder

Also, you can seed demo data

    php artisan db:seed --class=VolunteersWarehouseDemoSeeder
