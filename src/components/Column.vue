<template>
  <div class="column">
    <div class="header">
      <div class="title" @click="show">{{ title }}</div>
      <button class="delete" @click="deleteBtn" />
    </div>
    <Card
      v-for="(card, i) in cards"
      :title="card.title"
      :desc="card.desc"
      :key="i"
      :columnIndex="columnIndex"
      :cardIndex="i"
      :colLength="cards.length"
      :boardLength="$store.state.board.length"
    />
    <button class="addCard" @click="addCard"><div /></button>
  </div>
</template>

<script>
import Card from "./Card";
import CardModal from "./CardModal";
import ColumnModal from "./ColumnModal";

export default {
  name: "Column",
  components: {
    Card,
    CardModal,
    ColumnModal,
  },
  props: {
    columnIndex: Number,
    title: String,
    cards: Array,
  },
  watch: {
    cards() {
      this.$forceUpdate();
    },
  },
  methods: {
    show() {
      this.$modal.show(
        ColumnModal,
        { columnIndex: this.columnIndex },
        { height: "auto" }
      );
    },
    deleteBtn() {
      this.$store.commit("delColumn", this.columnIndex);
    },
    addCard() {
      const newCard = { title: "New Card", desc: "New Card Description" };
      this.$store.commit("addCard", {
        columnIndex: this.columnIndex,
        card: newCard,
      })
      // this.$modal.show(
      //   CardModal,
      //   { columnIndex: this.columnIndex, cardIndex: this.cards.length - 1 },
      //   { height: "auto" }
      // );
      this.$forceUpdate();
    },
  },
};
</script>

<style lang="scss" scoped>
.column {
  display: flex;
  flex-direction: column;
  width: 250px;
  border: 2px solid red;
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
  .header {
    display: flex;
    .title {
      flex-grow: 1;
      font: 2em bold sans-serif;
    }
    .delete {
      background: url("../assets/trash-alt-regular.svg") no-repeat ;
      width: 20px;
      height: 20px;
      border: 0px;
      margin: 5px;
    }
  }
  .addCard {
    div {
      background: url("../assets/plus-solid.svg") no-repeat ;
      text-align: center;
      width: 20px;
      height: 20px;
      border: 0px;
      margin: 5px;
    }
    border: 0px;
    border-radius: 5px;
    background: lightgreen;
    margin: 5px;
  }
}
</style>
