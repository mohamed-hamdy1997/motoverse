/**
 * Returns a submit handler that creates or updates an admin resource.
 * Updates are sent as POST + `_method=put` so file uploads work (multipart forms cannot use PUT).
 */
export function useResourceForm(form, routePrefix, id = null) {
    return () => {
        if (id) {
            form.transform((data) => ({...data, _method: 'put'}))
                .post(route(`${routePrefix}.update`, id), {preserveScroll: true});
            return;
        }

        form.post(route(`${routePrefix}.store`), {preserveScroll: true});
    };
}
