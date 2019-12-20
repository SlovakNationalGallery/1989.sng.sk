import VueRouter from 'vue-router'

import JournalEntriesGallery from './components/JournalEntriesGallery'
import DayEntriesGallery from './components/DayEntriesGallery'

const router = new VueRouter({
    mode: 'history',
    routes: [
      {
        path: '/dennik/:date?',
        component: JournalEntriesGallery,
        name: 'journal-entries',
        props: ({params, query}) => ({ date: params.date, filter: query.filter }),
        meta: { transitionName: 'slide' },
      },
      {
        path: '/:date?',
        component: DayEntriesGallery,
        name: 'days',
      }
    ]
})

export default router
