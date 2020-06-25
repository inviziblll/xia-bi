import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CARDS]: (state, cards) => {
    Vue.set(state, 'cards', cards)
  },
  [type.ADD_CARD]: (state, card) => {
    state.cards.push(card);
  },
  [type.UPDATE_CARD]: (state, card) => {
    state.cards.forEach((element, index) => {
      if(element.id === card.id) {
        Vue.set(state.cards, index, card);
      }
    });
  },
  [type.REMOVE_CARD]: (state, cardId) => {
    let cards = state.cards.filter((element) => {
      if (element.id !== cardId)
        return element
    });
    Vue.set(state, 'cards', cards);
  }
}
