import { createRouter, createWebHistory } from 'vue-router'
import MainPage from '../pages/index.vue'
import LoginPage from '../pages/login.vue'
import MakingIndexPage from '../pages/making/index.vue'
import CreateMakingPage from '../pages/making/create.vue'
import EditMakingPage from '../pages/making/[id].vue'
import CreatingMain from '../pages/creating/index.vue'
import CreatingTierlistCreatePage from '../pages/creating/create_tierlist.vue'
import EditTierlistId from '../pages/creating/[id].vue'
import CreatingItemsId from '../pages/creating/items/[id].vue'
import CreatingItemsCreate from '../pages/creating/items/create[id].vue'
import EditItems from '../pages/creating/items/edit_[id]_item[item_id].vue'

const routes = [
  {
    path: '/',
    name: 'Main',
    component: MainPage
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/making',
    name: 'makingIndex',
    component: MakingIndexPage
  },
  {
    path: '/making/create',
    name: 'CreateMakingPage',
    component: CreateMakingPage
  },
  {
    path: '/making/:id',
    name: 'EditMakingPage',
    component: EditMakingPage
  },
  {
    path: '/creating',
    name: 'TierlistIndexPage',
    component: CreatingMain
  },
  {
    path: '/creating/create_tierlist',
    name: 'CreatingTierlistCreatePage',
    component: CreatingTierlistCreatePage
  },
  {
    path: '/creating/:id',
    name: 'EditTierlistId',
    component: EditTierlistId
  },
  {
    path: '/creating/items/:id',
    name: 'CreatingItemsId',
    component: CreatingItemsId
  },
  {
    path: '/creating/items/create:id',
    name: 'CreatingItemsCreate',
    component: CreatingItemsCreate
  },
  {
    path: '/creating/items/edit_:id:item_id',
    name: 'EditItems',
    component: EditItems
  },
  // {
  //   path: '/about',
  //   name: 'about',
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  // }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
