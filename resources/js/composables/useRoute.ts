import { computed } from 'vue';

export function useRoute() {
  return computed(() => {
    return (window as any).route;
  });
}

export function route(name: string, params?: any): string {
  return (window as any).route?.(name, params) ?? '/';
}
