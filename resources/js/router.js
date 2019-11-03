import VueRouter from 'vue-router'

import JournalEntriesGallery from './components/JournalEntriesGallery'
import DayEntriesGallery from './components/DayEntriesGallery'

const router = new VueRouter({
    mode: 'history',
    routes: [
      {
        path: '/journal-entries/:date?',
        component: JournalEntriesGallery,
        name: 'journal-entries',
        props: ({params, query}) => ({ date: params.date, filter: query.filter }),
        meta: { transitionName: 'slide' },
      },
      {
        path: '/day/:date?',
        component: DayEntriesGallery,
        name: 'day-entries',
        props: ({params}) => ({ date: params.date}),
      }
    ]
})

export default router
