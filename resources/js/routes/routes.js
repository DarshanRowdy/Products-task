import { lazy } from 'react';


export default [
  {
    path: 'dashboard',
    component: lazy(() => import('../components/Dashboard')),
    exact: true,
  },
  {
    path: 'category',
    component: lazy(() => import('../components/Category')),
    exact: true,
  },
]
