import VueRouter from 'vue-router'

import JournalEntriesGallery from './components/JournalEntriesGallery'

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/journal-entries/:date?', component: JournalEntriesGallery, props: ({params, query}) => ({ date: params.date, filter: query.tag }) }
    ]
})

export default router
