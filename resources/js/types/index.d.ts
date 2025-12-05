import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

/**
 * Declare the global route() helper provided by Laravel
 * This is automatically available in all Vue components via Inertia
 */
declare global {
  /**
   * Generate a URL for the given named route
   * @param name The route name
   * @param params Route parameters (can be a single ID or object of params)
   * @param absolute Generate absolute URL
   * @param config Additional config
   */
  function route(
    name: string,
    params?: string | number | Record<string, any> | (string | number)[],
    absolute?: boolean,
    config?: any
  ): string;

  interface Window {
    route: typeof route;
  }
}

/**
 * Declare route() in Vue component global properties
 */
declare module 'vue' {
  interface ComponentCustomProperties {
    route: typeof route;
  }
}

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
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
}

export type BreadcrumbItemType = BreadcrumbItem;
