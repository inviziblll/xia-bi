import Vue from 'vue'
import Router from 'vue-router'

import NavBar from '@/components/navigation/NavBar';
import ToolBar from '@/components/navigation/ToolBar';
import Login from '@/components/pages/Login';

//Other
import Home from '@/components/pages/Home'
import Users from '@/components/pages/Users'
import Clients from '@/components/pages/Clients'
import Cards from '@/components/pages/Cards'
import Divisions from '@/components/pages/Divisions'
import Companies from '@/components/pages/Companies'
import Analytics from '@/components/pages/Analytics'

//Shops
import Shops from '@/components/pages/Shops'
import ShopShifts from '@/components/pages/ShopShifts'
import ShopTypes from '@/components/pages/ShopTypes'
import Shifts from '@/components/pages/Shifts'
import Roles from '@/components/pages/Roles'
import Regions from '@/components/pages/Regions'
import Cities from '@/components/pages/Cities'
import StaffPlans from '@/components/pages/StaffPlans'

//Products
import Products from '@/components/pages/Products';
import ProductTypes from '@/components/pages/ProductTypes';
import ProductGroups from '@/components/pages/ProductGroups';
import ProductBrands from '@/components/pages/ProductBrands';
import MeasureTypes from '@/components/pages/MeasureTypes';
import ProductGroupPlans from '@/components/pages/ProductGroupPlans';
import ProductGroupPlanTypes from '@/components/pages/ProductGroupPlanTypes';
import ProductRemains from '@/components/pages/ProductRemains';

import VisitLogs from '@/components/pages/VisitLogs';
import Operations from '@/components/pages/Operations';

import Warehouses from '@/components/pages/Warehouses';
import WarehouseTypes from '@/components/pages/WarehouseTypes';

import Coeffs from '@/components/pages/Coeffs';
import CoeffTypes from '@/components/pages/CoeffTypes';

import CheckHeaders from '@/components/pages/CheckHeaders';
import CheckTypes from '@/components/pages/CheckTypes';
import CheckOperations from '@/components/pages/CheckOperations';
import CashDesc from '@/components/pages/CashDesc';
import UploadReport from '@/components/pages/UploadReport';


import Discounts from '@/components/pages/Discounts';
import ShopGrades from '@/components/pages/ShopGrades';

import Profile from '@/components/pages/Profile';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      components: {default: Home, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/profile',
      name: 'Profile',
      components: {default: Profile, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/login',
      name: 'Login',
      components: {default: Login}
    },
    {
      path: '/users',
      name: 'Users',
      components: {default: Users, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/clients',
      name: 'Clients',
      components: {default: Clients, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/cards',
      name: 'Cards',
      components: {default: Cards, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/divisions',
      name: 'Divisions',
      components: {default: Divisions, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/companies',
      name: 'Companies',
      components: {default: Companies, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/analytics',
      name: 'Analytics',
      components: {default: Analytics, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/shops',
      name: 'Shops',
      components: {default: Shops, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/shifts',
      name: 'Shifts',
      components: {default: Shifts, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/roles',
      name: 'Roles',
      components: {default: Roles, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/shops/shifts',
      name: 'ShopShifts',
      components: {default: ShopShifts, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/shops/types',
      name: 'ShopTypes',
      components: {default: ShopTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/regions',
      name: 'Regions',
      components: {default: Regions, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/cities',
      name: 'Cities',
      components: {default: Cities, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/staffplans',
      name: 'StaffPlans',
      components: {default: StaffPlans, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/products',
      name: 'Products',
      components: {default: Products, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/product-types',
      name: 'ProductTypes',
      components: {default: ProductTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/product-groups',
      name: 'ProductGroups',
      components: {default: ProductGroups, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/product-brand',
      name: 'ProductBrands',
      components: {default: ProductBrands, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/measure-types',
      name: 'MeasureTypes',
      components: {default: MeasureTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/product-group-plans',
      name: 'ProductGroupPlans',
      components: {default: ProductGroupPlans, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/product-group-plan-types',
      name: 'ProductGroupPlanTypes',
      components: {default: ProductGroupPlanTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/productremains',
      name: 'ProductRemains',
      components: {default: ProductRemains, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/visit-logs',
      name: 'VisitLogs',
      components: {default: VisitLogs, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/operations',
      name: 'Operations',
      components: {default: Operations, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/warehouses',
      name: 'Warehouses',
      components: {default: Warehouses, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/warehouse-types',
      name: 'WarehouseTypes',
      components: {default: WarehouseTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/coeffs',
      name: 'Coeffs',
      components: {default: Coeffs, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/coefftypes',
      name: 'CoeffTypes',
      components: {default: CoeffTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/checkheaders',
      name: 'CheckHeaders',
      components: {default: CheckHeaders, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/checkoperations',
      name: 'CheckOperations',
      components: {default: CheckOperations, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/checktypes',
      name: 'CheckTypes',
      components: {default: CheckTypes, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/cashdesc',
      name: 'CashDesc',
      components: {default: CashDesc, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/uploadreport',
      name: 'UploadReport',
      components: {default: UploadReport, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/discounts',
      name: 'Discounts',
      components: {default: Discounts, navbar: NavBar, toolbar:ToolBar}
    },
    {
      path: '/shopgrades',
      name: 'ShopGrades',
      components: {default: ShopGrades, navbar: NavBar, toolbar:ToolBar}
    },

  ]
})
