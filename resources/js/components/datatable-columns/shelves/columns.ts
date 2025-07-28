import DataTableDropdown from '@/components/datatable-columns/shelves/data-table-dropdown.vue';
import { Button } from '@/components/ui/button';
import { Shelve } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
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
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(DataTableDropdown, { shelve: row.original }),
    },
];
