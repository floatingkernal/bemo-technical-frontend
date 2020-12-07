<template>
  <div class="card">
    <div class="title" @click="showDesc">{{ title }}</div>
    <button @click='moveLoc("UP")' class="up"  v-if="cardIndex - 1 >= 0" />
    <button @click='moveLoc("DOWN")' class="down"  v-if="cardIndex + 1 < colLength" />
    <button @click='moveLoc("LEFT")' class="left"  v-if="columnIndex - 1 >= 0" />
    <button @click='moveLoc("RIGHT")' class="right"  v-if="columnIndex + 1 < boardLength" />
  </div>
</template>

<script>
import CardModal from "./CardModal";

export default {
  name: "Card",
  props: {
    columnIndex: Number,
    cardIndex: Number,
    // title: String,
    desc: String,
    colLength: Number,
    boardLength: Number,
  },
  computed: {
    title: function() {
      return this.$store.state.board[this.columnIndex].cards[this.cardIndex].title
    }
  },
  watch: {
    colLength() {
      this.$forceUpdate();
    },
    boardLength() {
      this.$forceUpdate();
    },
  },
  methods: {
    showDesc() {
      this.$modal.show(
        CardModal,
        { columnIndex: this.columnIndex, cardIndex: this.cardIndex },
        { height: "auto" },
        { 'before-close':() => this.$forceUpdate()}
      );
    },
    moveLoc(dir) {
      const payload = {
        direction: dir,
        columnIndex: this.columnIndex,
        cardIndex: this.cardIndex,
      }
      this.$store.commit('updateCardLoc', payload)
    },
    up() {
      console.log("going UP");
    },
    down() {
      console.log("going DOWN");
    },
    left() {
      console.log("going LEFT");
    },
    right() {
      console.log("going RIGHT");
    },
  },
};
</script>

<style lang="scss" scoped>
.card {
  display: flex;
  border: 2px solid lightgrey;
  border-radius: 5px;
  margin: 3px;
  padding: 5px;

  .title {
    flex-grow: 1;
    text-align: start;
  }
  button {
      width: 15px;
      height: 15px;
      border: 0px;
      margin: 5px;
  }
  .up {
    background: url("../assets/arrow-up-solid.svg") no-repeat ;
  }
  .down {
    background: url("../assets/arrow-down-solid.svg") no-repeat ;
  }
  .left {
    background: url("../assets/arrow-left-solid.svg") no-repeat ;
  }
  .right {
    background: url("../assets/arrow-right-solid.svg") no-repeat ;
  }
  &:hover {
    cursor: pointer;
  }
}
</style>
