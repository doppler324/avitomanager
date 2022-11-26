export default [
    {
        path: '/projects',
        name: 'projects',
        component: () => import('@/views/projects/Projects.vue'),
        meta: {
            layout: 'horizontal',

        }

    }
]
