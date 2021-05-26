<template>
  <div id="app">
    <div class="a">aa</div>
    <div class="b">bb</div>
    <div class="c">ccc</div>
  </div>
</template>

<script>
import SampleRequest from '@/api/sample-request';
const sampleRequest = new SampleRequest();
export default {
  name: 'App',
  created(){
    this.getData();
  },
  methods: {
    async getData(){
      const data = await sampleRequest.doRequest();
      console.log('Data:', data);
    },
  },
};
</script>
<style lang="scss" scoped>
#app{
    width: 100vw;
    height: 100vh;
	display: grid;
	grid-template-columns: 1fr 1fr 1fr;

	.a{
		background: rgb(150,150,150);
	}
	.b{
		background: rgb(120,120,120);
	}
	.c{
		background: rgb(130,130,130);
	}
    .a, .b, .c{
        height: 100vh;
    }
}
</style>