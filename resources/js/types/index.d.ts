import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    items?: NavItem[];
    permissions?: string[];
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    status: Status;
    roles?: Role[];
}

/**
 *
 * Digital Collection Interfaces
 *
 */

export interface Fund {
    id: number;
    name: string;
    acronym: string;
    digital_objects?: DigitalObject[];
}

export interface DigitalObject {
    id: number;
    title: string;
    image_name: string;
    image_thumb: string;
    image_derivative: string;
    fund_acronym: string;
    inventory_number: string;
    website_link: string;
    status: Status;
    created_at: string;
}

/** END OF DIGITAL COLLECTION INTERFACE */

export interface Pagination {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: any[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

export interface Role {
    id: number;
    name: string;
    slug: string;
    description: string;
    created_at: string;
    updated_at: string;
    permissions?: Permission[];
}

export interface Permission {
    id: number;
    name: string;
    slug: string;
    description: string;
    created_at: string;
    updated_at: string;
}

interface Status {
    id: number;
    name: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
