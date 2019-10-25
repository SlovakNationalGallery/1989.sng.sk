import VueRouter from 'vue-router'

import JournalEntriesGallery from './components/JournalEntriesGallery'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
          path: '/journal-entries/:date?',
          component: JournalEntriesGallery,
          name: 'journal-entries',
          props: ({params, query}) => ({ date: params.date, filter: query.filter })
        }
    ]
})

export default router
