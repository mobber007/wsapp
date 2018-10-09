const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const DashboardWrapper = () => import('~/pages/dashboard/wrapper').then(m => m.default || m)
const HomeWrapper = () => import('~/pages/home/wrapper').then(m => m.default || m)
const HomeIndex = () => import('~/pages/home/index').then(m => m.default || m)
const ProductsWrapper = () => import('~/pages/products/wrapper').then(m => m.default || m)
const ProductsIndex = () => import('~/pages/products/index').then(m => m.default || m)
const ProductsSingle = () => import('~/pages/products/single').then(m => m.default || m)
const PromotionsIndex = () => import('~/pages/promotions/index').then(m => m.default || m)
const FavoritesIndex = () => import('~/pages/favorites/index').then(m => m.default || m)
const InformationsIndex = () => import('~/pages/informations/index').then(m => m.default || m)
const ConfidentialityIndex = () => import('~/pages/confidentiality/index').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

export default [
  { path: '/', redirect: { name: 'home' } },
  { path: '/acasa',
    component: HomeWrapper,
    children: [
      { path: '', name: 'home', component: HomeIndex },
      { path: 'hot', name: 'home.hot', component: HomeIndex },
      { path: 'informatii', name: 'home.informations', component: InformationsIndex },
      { path: 'confidentialitate', name: 'home.confidentiality', component: ConfidentialityIndex }
    ] },
  { path: '/login', name: 'login', component: Login },
  { path: '/dashboard', name: 'dashboard', component: DashboardWrapper },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },
  { path: '/promotii', name: 'promotions', component: PromotionsIndex },
  { path: '/favorite', name: 'favorites', component: FavoritesIndex },
/*  { path: '/informatii', name: 'informations', component: InformationsIndex },*/
  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  { path: '/produse',
    component: ProductsWrapper,
    children: [
      { path: '', name: 'products', component: ProductsIndex },
      { path: ':id', name: 'products.single', component: ProductsSingle },
    ] },

  { path: '*', component: NotFound }
]
