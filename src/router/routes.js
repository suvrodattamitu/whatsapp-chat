import { createWebHashHistory, createRouter } from "vue-router"

import ChatEditor from '../components/ChatEditor'
import Settings from '../components/Settings'
import SupportAndDocs from '../components/SupportAndDocs'
import Members from '../components/members/AllMembers'

const routes = [
    {
        path: '/',
        name: 'editor',
        component: ChatEditor,
        meta: { title: 'Chat Editor' }
    },
    {
        path: '/members',
        name: 'members',
        component: Members,
        meta: { title: 'Chat Members' }
    },
    {
        path: '/settings',
        name: 'settings',
        component: Settings,
        meta: { title: 'Settings' }
    },
    {
        path: '/support',
        name: 'support',
        component: SupportAndDocs,
        meta: { title: 'Support' }
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach((to, from, next) => {

    if(to.meta){
        document.title = 'Ninja Live Chat :: ' + to.meta.title;
    }else{
        document.title = 'Ninja Live Chat';
    }

    next();

});

export default router;