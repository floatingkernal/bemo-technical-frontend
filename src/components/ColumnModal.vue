<template>
  <div class="modal">
    <input class="title" v-model="title" />
    <button class="save" @click="save">Save</button>
  </div>
</template>

<script>
export default {
  name: "ColumnModal",
  props: {
    columnIndex: Number,
  },
  data: () => ({
    title: "",
  }),
  mounted() {
    if (!this.$store.state.board) return;
    const board = this.$store.state.board;
    if (this.columnIndex >= board.length || this.columnIndex < 0) return;
    const column = board[this.columnIndex];
    this.title = column.title;
  },
  methods: {
    save() {
      this.$store.commit("updateColumnTitle", {
        index: this.columnIndex,
        title: this.title,
      });
      this.$forceUpdate();
      this.$emit("close");
    },
  },
};
</script>

<style lang="scss" scoped>
.modal {
  display: flex;
  flex-direction: column;
  background: rgb(168, 192, 100);
  .title {
    border: 2px solid lightgrey;
    background: white;
    border-radius: 5px;
    margin: 3px;
    padding: 5px;
  }
  .save {
    border: 0px;
    border-radius: 5px;
    margin: 3px;
    background: lightgreen;
  }
}
</style>
