import DataTableDropdown from '@/components/datatable-columns/role/data-table-dropdown.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Role } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue';

export const roleColumns: ColumnDef<Role>[] = [
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
        accessorKey: 'description',
        header: 'Descrição',
        cell: ({ row }) => row.original.description,
    },
    {
        accessorKey: 'created_at',
        header: 'Criado em',
        cell: ({ row }) => row.original.created_at,
    },
    {
        accessorKey: 'permissions',
        header: () => h('span', { class: 'block' }, 'Permissões'),
        cell: ({ row }) => {
            const permissions = row.original.permissions;
            // Check if permissions is empty or undefined
            if (!permissions || permissions.length === 0) {
                return h('div', { class: 'text-sm text-muted-foreground' }, 'Sem permissões');
            }
            return h(
                'div',
                {
                    class: 'flex flex-wrap gap-2 justify-start items-center',
                    style: { width: '500px' },
                },
                permissions.map((permission) =>
                    h(
                        Badge,
                        {
                            class: 'text-xs',
                            key: permission.id,
                        },
                        () => permission.name,
                    ),
                ),
            );
        },
    },
    {
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(DataTableDropdown, { role: row.original }),
    },
];
