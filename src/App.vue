<template>
  <div id="app">
    <Board />
    <button class="exportDB" @click="exportDB"> <div /></button>
  </div>
</template>

<script>
import Board from "@/components/Board";
import Axios from "axios";

export default {
  name: "App",
  components: {
    Board,
  },
  methods: {
    exportDB() {
      Axios.get("https://bemo-technical-backend.herokuapp.com/api/exportDB").catch(() => {
        alert("This Feature is not working")
      });
    },
  },
};
</script>

<style lang="scss">
.exportDB {
  position: absolute;
  bottom: 8px;
  right: 16px;
  font-size: 18px;
  height: 50px;
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
  border: 0px solid blue;
  background: rgb(223, 246, 255);
  div {
      background: url("./assets/download-solid.svg") no-repeat ;
      width: 20px;
      height: 20px;
      border: 0px;
      margin: 5px;
    }
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  display: flex;
}
</style>
