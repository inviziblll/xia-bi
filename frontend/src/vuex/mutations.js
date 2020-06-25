import auth from './mutatios/auth';
import shopGrades from './mutatios/shopGrades';
import template from './mutatios/template';
import notification from './mutatios/notification';
import discounts from './mutatios/discounts';
import reports from './mutatios/reports';
import clients from './mutatios/clients';
import cards from './mutatios/cards';
import divisions from './mutatios/divisions';
import companies from './mutatios/companies';
import shops from './mutatios/shops';
import shopShifts from './mutatios/shopShifts';
import shopTypes from './mutatios/shopTypes';
import shifts from './mutatios/shifts';
import roles from './mutatios/roles';
import users from './mutatios/users';
import regions from './mutatios/regions';
import cities from './mutatios/cities';
import staffPlans from './mutatios/staffPlans';
import products from './mutatios/products';
import productTypes from './mutatios/productTypes';
import productBrands from './mutatios/productBrands';
import productRemains from './mutatios/productRemains';
import productGroups from './mutatios/productGroups';
import measureTypes from './mutatios/measureTypes';
import productGroupPlans from './mutatios/productGroupPlans';
import productGroupPlanTypes from './mutatios/productGroupPlanTypes';
import visitLogs from './mutatios/visitLogs';
import operations from './mutatios/operations';
import warehouses from "./mutatios/warehouses";
import warehouseTypes from "./mutatios/warehouseTypes";
import coeffs from './mutatios/coeffs';
import coeffTypes from './mutatios/coeffTypes';
import checkDetails from './mutatios/checkDetails';
import checkHeaders from './mutatios/checkHeaders';
import checkTypes from './mutatios/checkTypes';
import checkOperations from './mutatios/checkOperations';
import cashDescs from './mutatios/cashDescs';

const mutations = Object.assign({},
  auth,
  shopGrades,
  template,
  notification,
  discounts,
  reports,
  clients,
  cards,
  divisions,
  companies,
  shops,
  shifts,
  roles,
  shopShifts,
  shopTypes,
  users,
  regions,
  cities,
  staffPlans,
  products,
  productTypes,
  productBrands,
  productRemains,
  productGroups,
  measureTypes,
  productGroupPlans,
  productGroupPlanTypes,
  visitLogs,
  operations,
  warehouses,
  warehouseTypes,
  coeffs,
  coeffTypes,
  checkDetails,
  checkHeaders,
  checkOperations,
  checkTypes,
  cashDescs,
);
export default mutations;
