export default {
  install(app: any) {
    app.config.globalProperties.$route = (name: string, params?: any) => {
      // This will be called from Laravel's Ziggy in production
      // For now, we rely on the global route() function from Laravel
      return (window as any).route?.(name, params) ?? `/`;
    };
  },
};
