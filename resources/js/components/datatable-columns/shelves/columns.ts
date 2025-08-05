import DataTableDropdown from '@/components/datatable-columns/shelves/data-table-dropdown.vue';
import { Button } from '@/components/ui/button';
import { Shelve } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown, Check, Clock } from 'lucide-vue-next';
import { h } from 'vue';

export const shelveColumns: ColumnDef<Shelve>[] = [
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Nome', h(ArrowUpDown, { class: 'ml-2 h-4 w-4 cursor-pointer' })],
            );
        },
        cell: ({ row }) => h('div', row.getValue('name')),
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        isDefaultFilter: true,
    },
    {
        accessorKey: 'slug',
        header: 'Slug',
        cell: ({ row }) => row.original.slug,
    },
    {
        accessorKey: 'created_at',
        header: 'Criado em',
        cell: ({ row }) => row.original.created_at,
    },
    {
        accessorKey: 'deleted_at',
        header: 'Resolvido em',
        cell: ({ row }) => {
            const deletedAt = row.original.deleted_at;
            if (deletedAt) {
                return h(Check, { class: 'flex h-4 w-4 text-success items-center' });
            } else {
                return h(Clock, { class: 'h-4 w-4 text-warning text-center' });
            }
        },
    },

    {
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(DataTableDropdown, { shelve: row.original }),
    },
];
