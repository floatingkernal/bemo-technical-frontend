<template>
  <div class="modal">
      <input class="title" v-model="title">
      <textarea class="desc" v-model="desc" />
      <button class="save" @click="save"> Save </button>
  </div>
</template>

<script>
export default {
    name: "CardModal",
    props:{
        columnIndex:Number,
        cardIndex:Number,
    },
    data: () => ({
        title:"",
        desc:"",
    }),
    mounted() {
        if (!this.$store.state.board) return
        const board = this.$store.state.board
        if (this.columnIndex >= board.length || this.columnIndex < 0) return;
        const column = board[this.columnIndex]
        if (this.cardIndex > column.cards.length || this.cardIndex < 0) return
        const card = column.cards[this.cardIndex]
        this.title = card.title
        this.desc = card.desc
    },
    methods: {
        save() {
            const newCard = {title:this.title, desc:this.desc}
            this.$store.commit('updateCardItems', {columnIndex: this.columnIndex, cardIndex:this.cardIndex, card: newCard})
            this.$forceUpdate()
            this.$emit('close')
        }
    }
}
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
  .desc {
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