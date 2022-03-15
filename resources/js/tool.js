Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-promocodes',
      path: '/nova-promocodes',
      component: require('./components/Tool'),
    },
  ])
})
