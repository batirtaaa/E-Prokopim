<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Trait DbCompatible
 *
 * Menyediakan helper SQL yang kompatibel dengan MySQL dan PostgreSQL (Supabase).
 * Gunakan trait ini di semua Controller yang menggunakan selectRaw / groupByRaw
 * dengan fungsi tanggal seperti YEAR(), MONTH(), DATE_FORMAT().
 */
trait DbCompatible
{
    /**
     * Ekspresi SQL untuk mengekstrak TAHUN dari kolom tanggal.
     * MySQL  : YEAR(col)
     * PgSQL  : EXTRACT(YEAR FROM col)
     */
    protected function sqlYear(string $column): string
    {
        return config('database.default') === 'pgsql'
            ? "EXTRACT(YEAR FROM {$column})::int"
            : "YEAR({$column})";
    }

    /**
     * Ekspresi SQL untuk mengekstrak BULAN dari kolom tanggal.
     * MySQL  : MONTH(col)
     * PgSQL  : EXTRACT(MONTH FROM col)
     */
    protected function sqlMonth(string $column): string
    {
        return config('database.default') === 'pgsql'
            ? "EXTRACT(MONTH FROM {$column})::int"
            : "MONTH({$column})";
    }

    /**
     * Ekspresi SQL untuk memformat tanggal menjadi string "DD MonthName YYYY".
     * MySQL  : DATE_FORMAT(col, '%d %M %Y')
     * PgSQL  : TO_CHAR(col, 'DD Month YYYY')
     */
    protected function sqlDateFormatLong(string $column): string
    {
        return config('database.default') === 'pgsql'
            ? "TO_CHAR({$column}, 'DD Month YYYY')"
            : "DATE_FORMAT({$column}, '%d %M %Y')";
    }

    /**
     * Ekspresi SQL untuk memformat tanggal menjadi string "DD-MM-YYYY".
     * MySQL  : DATE_FORMAT(col, '%d-%m-%Y')
     * PgSQL  : TO_CHAR(col, 'DD-MM-YYYY')
     */
    protected function sqlDateFormatShort(string $column): string
    {
        return config('database.default') === 'pgsql'
            ? "TO_CHAR({$column}, 'DD-MM-YYYY')"
            : "DATE_FORMAT({$column}, '%d-%m-%Y')";
    }

    /**
     * Ekspresi SQL untuk memformat tanggal menjadi string "DD/MM/YYYY".
     * MySQL  : DATE_FORMAT(col, '%d/%m/%Y')
     * PgSQL  : TO_CHAR(col, 'DD/MM/YYYY')
     */
    protected function sqlDateFormatSlash(string $column): string
    {
        return config('database.default') === 'pgsql'
            ? "TO_CHAR({$column}, 'DD/MM/YYYY')"
            : "DATE_FORMAT({$column}, '%d/%m/%Y')";
    }

    /**
     * ORDER BY yang kompatibel untuk COALESCE(col1, col2) DESC.
     * Keduanya (MySQL & PgSQL) mendukung COALESCE dan ORDER BY ekspresi.
     */
    protected function sqlCoalesceOrder(string $col1, string $col2, string $direction = 'DESC'): string
    {
        return "COALESCE({$col1}, {$col2}) {$direction}";
    }
}
