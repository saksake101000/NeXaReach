<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaksi;

class TransaksiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total transaksi
        $totalTransaksi = Transaksi::count();

        // Menghitung total pendapatan (misalnya berdasarkan total_harga)
        $totalPendapatan = Transaksi::sum('total_harga');

        // Menghitung jumlah transaksi berdasarkan status
        $pending = Transaksi::where('status', 'pending')->count();
        $completed = Transaksi::where('status', 'completed')->count();
        $cancelled = Transaksi::where('status', 'cancelled')->count();

        return [
            Stat::make('Total Transaksi', $totalTransaksi)
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->icon('heroicon-o-credit-card')
                ->color('primary'),

            Stat::make('Pending Transaksi', $pending)
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Completed Transaksi', $completed)
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Cancelled Transaksi', $cancelled)
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
