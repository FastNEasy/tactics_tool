<template>
    <div id="canvasTest">
        <!-- <canvas id="canv" class="canvas-test" ></canvas> -->
        <!-- <button @click="drawRect()">Add Rect</button> -->
        <div>
            <img id="picture" class="updateImage" v-bind:src="image">
            <!-- <button id="dragItem" draggable="true">You can drag me!</button> -->
            <canvas 
                v-on:mousemove="updateCoordinates" 
                v-on:mouseup="handleMouseUp" 
                v-on:mousedown="handleMouseDown"
                v-on:mouseout="handleMouseOut" 
                id="canv" class="canvas-test" ></canvas>
            <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        </div>
        <button v-on:click="drawItem(0, 0, 0)">Draw item 0</button>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'TestCanvas',
        

        created() {
            this.getData();
            //this.mounted();
        },
        data() {
            return {
                sports: {},
                //sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                counter: 0,
                id: 56,
                canvas: null,
                context: null,
                img: null,
            }
        },
        mounted(){
            console.log("Izsaucas mounted");
            this.context = document.getElementById("canv");
            this.canvas = this.context.getContext('2d');
        },
        methods: { 
            async getData(){
                const {data} = await sampleRequest.getSportsTypes({ id:this.id});
                // this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
                console.log(`Sports Pic: ${this.base64Img}`);
                console.log(`Sports id: ${this.id}`);
            },
            drawItem(index, x, y) {
                console.log('args:', index, x, y);
                this.img = new Image();
                this.img.src = this.image;
                console.log('this.image:', this.image);
                this.img.onload = () => {
                    console.log('this.ctx:', this.canvas);
                    this.canvas.drawImage(this.img, x, y);
                }
            },
            updateCoordinates(event) {
                this.xpoint = event.clientX;
                this.ypoint = event.clientY;
            },
            draw() {
                
            },
            handleMouseDown(e) {
               
            },
            handleMouseUp(e) {

            },
            // also done dragging
            handleMouseOut(e) {
               
            },
            handleMouseMove(e) {
               
            },


        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
        #canv{
            padding: 0;
            margin: auto;
            display: block;
            width: 2040px; 
            height: 1680px; 
            border: 1px solid black;
            //background-color: #f1f1f1;
        }
        #dragItem{
            width: 100px;
            height: 100px;
            background-color: rgb(245, 230, 99);
            border: 10px solid rgba(136, 136, 136, .5);
            border-radius: 50%;
            touch-action: none;
            user-select: none;
            cursor: move;
        }
        #dragItem:active {
            background-color: rgba(168, 218, 220, 1.00);
        }
        #dragItem:hover {
            cursor: pointer;
            border-width: 20px;
        }

        #picture{
            width:70%;
            margin:auto;
            display: block;
        }
    }

</style>