import Axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

// const BASEURL = "http://127.0.0.1:8000";
const BASEURL = "https://bemo-technical-backend.herokuapp.com";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loading: true,
    board: [],
  },
  mutations: {
    setLoading: (state, loading) => {
      state.loading = loading;
    },
    setBoard: (state, board) => {
      state.board = board;
    },
    addColumn: (state, col) => {
      Axios.post(`${BASEURL}/api/addColumn`, { title: col.title }).then(
        (res) => {
          if (!res.data.cards) res.data.cards = []
          state.board.push(res.data);
        }
      );
    },
    delColumn: (state, index) => {
      const id = state.board[index].id;
      state.board.splice(index, 1);
      Axios.delete(`${BASEURL}/api/delColumn/${id}`);
    },
    updateColumnTitle: (state, payload) => {
      const id = state.board[payload.index].id;
      const data = { id: id, title: payload.title };
      Axios.post(`${BASEURL}/api/updateColumnTitle`, data).then((res) => {
        state.board[payload.index] = res.data;
      });
    },
    addCard: (state, payload) => {
      const data = {
        column_id: state.board[payload.columnIndex].id,
        title: payload.card.title,
        desc: payload.card.desc,
      };
      Axios.post(`${BASEURL}/api/addCard`, data).then((res) => {
        state.board[payload.columnIndex].cards.push(res.data);
      });
    },
    updateCardItems: (state, payload) => {
      const data = {
        card_id: state.board[payload.columnIndex].cards[payload.cardIndex].id,
        title: payload.card.title,
        desc: payload.card.desc
      }
      Axios.post(`${BASEURL}/api/updateCardItem`,data).then(res => {
        state.board[payload.columnIndex].cards[payload.cardIndex] = res.data;
      })
    },
    updateCardLoc: (state, payload) => {
      const card = state.board[payload.columnIndex].cards.splice(
        payload.cardIndex,
        1
      )[0];
      let col = state.board[payload.columnIndex]
      const data = {
        card_id: card.id,
        column_id:-1,
        old_column_id: col.id,
        direction: payload.direction
      }
      switch (payload.direction) {
        case "UP":
          state.board[payload.columnIndex].cards.splice(
            payload.cardIndex - 1,
            0,
            card
          );
          break;
        case "DOWN":
          state.board[payload.columnIndex].cards.splice(
            payload.cardIndex + 1,
            0,
            card
          );
          break;
        case "LEFT":
          col = state.board[payload.columnIndex-1];
          col.cards.push(card);
          data.column_id = col.id;
          break;
        case "RIGHT":
          col = state.board[payload.columnIndex+1];
          col.cards.push(card);
          data.column_id = col.id;
        break;

        default:
          break;
      }
      Axios.post(`${BASEURL}/api/updateCardLoc`, data)
    },
  },
  actions: {
    loadBoard: ({ commit }) => {
      commit("setLoading", true);
      Axios.get(`${BASEURL}/api/getBoard`).then(res => {
        const board = res.data
        board.forEach(col => {
          if (!col.cards) col.cards = []
        });
        commit("setBoard", board);
        commit("setLoading", false);
      }).catch((err) =>
        console.error(err)
      );
    },
  },
  modules: {},
});
