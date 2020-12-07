<template>
  <div class="board">
    <Column
      v-for="(col, i) in columns"
      :key="i"
      :columnIndex="i"
      :title="col.title"
      :cards="col.cards"
    />
    <button class="addColumn" @click="addColumn"><div /></button>
  </div>
</template>

<script>
import Column from "./Column";
import ColumnModal from "./ColumnModal.vue";
export default {
  name: "Board",
  components: {
    Column,
    ColumnModal,
  },
  computed: {
      columns: function() {
          return this.$store.state.board;
      }
  },
  methods: {
    addColumn() {
      const newCol = { title: "New Column", cards: [] };
      this.$store.commit("addColumn", newCol);
    //   this.$modal.show(
    //     ColumnModal,
    //     { columnIndex: this.columns.length - 1 },
    //     { height: "auto" }
    //   );
    },
  },
};
</script>

<style lang="scss">
.board {
  display: flex;
  flex-wrap: wrap;
  height: 80vh;
  .addColumn {
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
    border: 2px solid red;
    background: rgb(255, 223, 223);
    div {
      background: url("../assets/plus-solid.svg") no-repeat ;
      width: 20px;
      height: 20px;
      border: 0px;
      margin: 5px;
    }
  }
}

* button:hover {
  cursor: pointer;
}
</style>
