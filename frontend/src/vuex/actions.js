import auth from './actions/auth';
import shopGrades from './actions/shopGrades';
import discounts from './actions/discounts';
import reports from './actions/reports';
import clients from './actions/clients';
import cards from './actions/cards';
import divisions from './actions/divisions';
import companies from './actions/companies';
import shops from './actions/shops';
import shopShifts from './actions/shopShifts';
import shopTypes from './actions/shopTypes';
import shifts from './actions/shifts';
import roles from './actions/roles';
import users from './actions/users';
import regions from './actions/regions';
import cities from './actions/cities';
import staffPlans from './actions/staffPlans';
import products from './actions/products';
import productTypes from './actions/productTypes';
import productBrands from './actions/productBrands';
import productRemains from './actions/productRemains';
import productGroups from './actions/productGroups';
import measureTypes from './actions/measureTypes';
import productGroupPlans from './actions/productGroupPlans';
import productGroupPlanTypes from './actions/productGroupPlanTypes';
import visitLogs from './actions/visitLogs';
import operations from './actions/operations';
import warehouseTypes from './actions/warehouseTypes';
import warehouses from './actions/warehouses';
import coeffs from './actions/coeffs';
import coeffTypes from './actions/coeffTypes';
import checkDetails from './actions/checkDetails';
import checkHeaders from './actions/checkHeaders';
import checkTypes from './actions/checkTypes';
import checkOperations from './actions/checkOperations';
import cashDescs from './actions/cashDescs';
import uploadReport from './actions/uploadReport';

const actions = Object.assign({},
  reports,
  shopGrades,
  discounts,
  clients,
  cards,
  auth,
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
  uploadReport,

);
export default actions;
