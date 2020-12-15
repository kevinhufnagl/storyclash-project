<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /*

    DDL

    CREATE TABLE `reports` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `icon` varchar(255) NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    );

    */

    protected $fillable = [
        'icon',
        'title'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
