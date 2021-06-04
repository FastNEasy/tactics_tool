<template>
    <div id="canvasTest">
        <!-- <canvas id="canv" class="canvas-test" ></canvas> -->
        <!-- <button @click="drawRect()">Add Rect</button> -->
        <div>
            <!-- <button id="dragItem" draggable="true">You can drag me!</button> -->
            <canvas v-on:mousemove="updateCoordinates" id="canv" class="canvas-test" ></canvas>
            <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        </div>
    </div>
</template>

<script >
    export default {
        name: 'TestCanvas',
        created() {
        },
        data() {
            return {
                position: {
                    x: 0,
                    y: 0
                },
                //vueCanvas: null,
                // radius: 50,
                xpoint: 0,
                ypoint: 0,
                counter: 0,
            }
        },
        // mounted(){
        //     var c = document.getElementById("canv");
        //     var ctx = c.getContext("2d");    
        //     this.vueCanvas = ctx;
        // },
        methods: { 
            updateCoordinates(event) {
                this.xpoint = event.clientX;
                this.ypoint = event.clientY;
            },

            // drawRect() {
            //     // clear canvas
            //     // this.vueCanvas.clearRect(0, 0, 400, 200);
            //     // draw rect
            //     this.vueCanvas.beginPath();
            //     if(this.counter%2 !=0){
            //         this.vueCanvas.fillStyle = "#FF0000";
            //     }else{
            //         this.vueCanvas.fillStyle = "#7a7171";
            //     }
            //     if(this.radius<=0){
            //         this.radius = 50;
            //         this.xpoint-=15;
            //         this.ypoint-=15;
            //     }
            //     this.vueCanvas.arc(this.xpoint, this.ypoint, this.radius, 0, 2 * Math.PI);
            //     this.vueCanvas.fill();
            //     this.radius-=5;
            //     this.vueCanvas.stroke();
            //     this.counter++;      
            // },
        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
        .canvas-test{
            padding: 0;
            margin: auto;
            display: block;
            width: 640px; 
            height: 480px; 
            border: 1px solid black;
            background-color: #f1f1f1;
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
    }

</style>