import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_SHOP_GRADES]: (state, shopGrades) => {
    Vue.set(state, 'shopGrades', shopGrades)
  },
  [type.ADD_SHOP_GRADE]: (state, shopGrade) => {
    state.shopGrades.push(shopGrade);
  },
  [type.UPDATE_SHOP_GRADE]: (state, shopGrade) => {
    state.shopGrades.forEach((element, index) => {
      if(element.id === shopGrade.id) {
        Vue.set(state.shopGrades, index, shopGrade);
      }
    });
  },
  [type.REMOVE_SHOP_GRADE]: (state, shopGradeId) => {
    let shopGrades = state.shopGrades.filter((element) => {
      if (element.id !== shopGradeId)
        return element
    });
    Vue.set(state, 'shopGrades', shopGrades);
  }
}
