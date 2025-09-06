<?php 
/*
 * File: Database.php
 * Project: GamerHelpDesk
 * Created Date: September 2025
 * Author: danutz0501 (M. Dumitru Daniel)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (M. Dumitru Daniel)
 *  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace GamerHelpDesk\Database;

use GamerHelpDesk\Helper\SingletonTrait\SingletonTrait;
use PDO;
use PDOException;

/**
 * Database class
 * Handles database connections and queries
 * 
 * @package GamerHelpDesk\Database
 * @version 1.0.0
 */
class Database 
{
    /**
     * Singleton instance
     * @var Database
     */
    use SingletonTrait;

    /**
     * PDO instance
     * @var \PDO
     */
    public protected(set) PDO $pdo
    {
        get
        {
            return $this->pdo;
        }
    }

    /**
     * Private constructor to prevent direct instantiation.
     * This constructor is private to enforce the Singleton pattern.
     */
    private function __construct(){}

    /**
     * Connect to the database
     * Using PDO for database connection SQLITE for now
     * @return void
     */
    public function connect($path): void
     {
        $this->pdo = new PDO(dsn: 'sqlite:' . $path . '/gamerhelpdesk.db');
        $this->pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        $this->createTables();
     }

     protected function createTables(): void
     {
        $sql = "CREATE TABLE IF NOT EXISTS notes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            content TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
        $sql = "CREATE TABLE IF NOT EXISTS speed_dial (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            url TEXT NOT NULL,
            image TEXT NOT NULL,
            description TEXT NOT NULL,
            category TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
        $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
        $sql ="CREATE TABLE IF NOT EXISTS servicess (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT NOT NULL,
            image TEXT NOT NULL,
            url TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
        $sql = "CREATE TABLE IF NOT EXISTS media (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            location TEXT NOT NULL,
            type TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
        $sql = "CREATE TABLE IF NOT EXISTS slideshow (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            content TEXT NOT NULL
        )";
        $this->pdo->exec(statement: $sql);
     }
}