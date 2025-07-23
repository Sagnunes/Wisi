import DataTableDropdown from '@/components/datatable-columns/user/data-table-dropdown.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { User } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue';

export const userColumns: ColumnDef<User>[] = [
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
        accessorKey: 'email',
        header: 'Email',
        cell: ({ row }) => row.original.email,
    },
    {
        accessorKey: 'created_at',
        header: 'Criado em',
        cell: ({ row }) => row.original.created_at,
    },
    {
        accessorKey: 'status',
        header: () => h('span', { class: 'block' }, ''),
        cell: ({ row }) => {
            const status = row.original.status;

            return h(
                'div',
                {
                    class: 'flex flex-wrap gap-2 justify-start items-center w-max',
                },
                [
                    h(
                        Badge,
                        {
                            class: 'text-xs',
                            key: status.id,
                            variant: status.id === 1 ? 'warning' : status.id === 2 ? 'success' : 'destructive',
                        },
                        () => status.name,
                    ),
                ],
            );
        },
    },
    {
        accessorKey: 'roles',
        header: () => h('span', { class: 'block' }, 'Perfis'),
        cell: ({ row }) => {
            const roles = row.original.roles;
            if (!roles || roles.length === 0) {
                return h('div', { class: 'text-sm text-muted-foreground' }, 'Sem perfis');
            }
            return h(
                'div',
                {
                    class: 'flex flex-wrap gap-2 justify-start items-center',
                    style: { width: '' },
                },
                roles.map((role) =>
                    h(
                        Badge,
                        {
                            class: 'text-xs',
                            key: role.id,
                        },
                        () => role.name,
                    ),
                ),
            );
        },
    },
    {
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(DataTableDropdown, { user: row.original }),
    },
];
