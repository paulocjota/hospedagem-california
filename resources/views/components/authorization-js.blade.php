<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('roles', {
        loggedUserRoles: @json(auth()->user()->getRoleNames()),
        has(role) {
            return this.loggedUserRoles.includes(role);
        }
    });

    Alpine.store('permissions', {
        loggedUserPermissions: @json(auth()->user()->getPermissionNames()),
        has(permission) {
            return this.loggedUserPermissions.includes(permission);
        }
    });
});
</script>