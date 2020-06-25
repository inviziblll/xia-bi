
import moment from 'moment';
import * as type from "./types";

const getters = {
  getDivisions: (state) => state.divisions.reduce((devisions, devision) => {
    return [...devisions, Object.assign({}, devision, {user: state.users.find((user) => user.id == devision.user_id)})];
  }, []),
  getCities: (state) => state.cities.reduce((cities, city) => {
    return [...cities, Object.assign({}, city, {region: state.regions.find((region) => region.id == city.region_id)})];
  }, []),
  getShops: (state) => state.shops.reduce((shops, shop) => {
    return [...shops, Object.assign({}, shop, {
      division: state.divisions.find((division) => division.id === shop.division_id),
      company: state.companies.find((company) => company.id === shop.company_id),
      type: state.shopTypes.find((type) => type.id === shop.shop_type_id),
      city: state.cities.find((city) => city.id === shop.city_id)
    })]
  }, []),
  getShopShifts: (state) => state.shopShifts.reduce((shopShifts, shopShift) => {
    return [...shopShifts, Object.assign({}, shopShift,{
      shop: state.shops.find((shop) => shop.id === shopShift.shop_id),
      user: state.users.find((user) => user.id === shopShift.user_id),
      role: state.roles.find((role) => role.id === shopShift.role_id),
      shift: state.shifts.find((shift) => shift.id === shopShift.shift_id),
    })]
  }, []),
  getStaffPlans: (state) => state.staffPlans.reduce((staffPlans, staffPlan) => {
    return [...staffPlans, Object.assign({}, staffPlan,{
      shop: state.shops.find((shop) => shop.id === staffPlan.shop_id),
      role: state.roles.find((role) => role.id === staffPlan.role_id),
    })]
  }, []),
  getProducts: (state) => state.products.reduce((products, product) => {
    return [...products, Object.assign({}, product, {
      type: state.productTypes.find((productType) => productType.id === product.product_type_id),
      brand: state.productBrands.find((productBrand) => productBrand.id === product.product_brand_id),
      group: state.productGroups.find((productGroup) => productGroup.id === product.product_group_id),
      measure: state.measureTypes.find((measureType) => measureType.id === product.measure_type_id)
    })]
  }, []),
  getProductGroupPlans: (state) => state.productGroupPlans.reduce((productGroupPlans, productGroupPlan) => {
    return [...productGroupPlans, Object.assign({}, productGroupPlan, {
      type: state.productGroupPlanTypes.find((productGroupPlanType) => productGroupPlanType.id === productGroupPlan.product_group_plan_type_id),
      group: state.productGroups.find((productGroup) => productGroup.id === productGroupPlan.product_group_id)
    })]
  }, []),
  getWarehouses: (state) => state.warehouses.reduce((warehouses, warehouse) => {
    return [...warehouses, Object.assign({}, warehouse, {
      shop: state.shops.find((shop) => shop.id === warehouse.shop_id),
      type: state.warehouseTypes.find((warehouseType) => warehouseType.id === warehouse.warehouse_type_id)
    })]
  }, []),
  getCoeffs: (state) => state.coeffs.reduce((coeffs, coeff) => {
    return [...coeffs, Object.assign({}, coeff, {
      type: state.coeffTypes.find((coeffType) => coeffType.id === coeff.coeff_type_id)
    })]
  }, []),
  getCheckDetails: (state, dispatch) => state.checkDetails.reduce((checkDetails, checkDetail) => {
    return [...checkDetails, Object.assign({}, checkDetail, {
      header: state.checkHeaders.find((checkHeader) => checkHeader.id === checkDetail.check_header_id),
      // header: dispatch(type.GET_CHECK_HEADER, checkDetail.check_header_id),
      product: state.products.find((product) => product.id === checkDetail.product_id),
      user: state.users.find((user) => user.id === checkDetail.user_id),
    })]
  }, []),
  getCashDescs: (state) => state.cashDescs.reduce((cashDescs, cashDesc) => {
    return [...cashDescs, Object.assign({}, cashDesc, {
      shop: state.shops.find((shop) => shop.id === cashDesc.shop_id)
    })]
  }, []),
  getPivotData: (state) => state.reports.reduce((reports, report) =>
    [...reports, Object.assign({}, report, {data: JSON.parse(report.data), share: 0})]
  , []).concat(state.reportsShare.reduce((reportsShare, reportShare) =>
      [...reportsShare, Object.assign({}, {idShare: reportShare.id, title: reportShare.report.title, cube: reportShare.report.cube, data: JSON.parse(reportShare.report.data), share: 1, user: reportShare.user})]
  , []))
};

export default getters;
