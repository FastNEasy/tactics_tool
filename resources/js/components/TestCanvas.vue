<template>
    <div id="canvasTest">
        <!-- <canvas id="canv" class="canvas-test" ></canvas> -->
        <!-- <button @click="drawRect()">Add Rect</button> -->
        <div>
            <!-- <button id="dragItem" draggable="true">You can drag me!</button> -->
            <canvas 
                v-on:mousemove="updateCoordinates" 
                v-on:mouseup="handleMouseUp" 
                v-on:mousedown="handleMouseDown"
                v-on:mouseout="handleMouseOut" 
                id="canv" class="canvas-test" width =800px height=600px style="border:2px solid black" @click="getRelativeCoords(xpoint, ypoint)"></canvas >
            <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
           
           
        </div>
       
        
        <button v-on:click="drawItem(0, 0, 100)">Draw item 0</button>
        <button v-on:click="saveCoords(xpoint, ypoint)">save</button>
        <div ref="draggableContainer" id="draggable-container">
            <div id="circle" class="circle" @mousedown="dragMouseDown"></div>    
        </div>
    </div>
</template>

<script>

    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'TestCanvas',
        created() {
            this.getData();
        },
        data() {
            return {
                sports: {},
                sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                counter: 0,
                id: 69,
                canvas: null,
                context: null,
                img: null,
                gCanvasElement: null,
                cordsArr:[],
                positions:{
                    clientX:undefined,
                    clientY:undefined,
                    movementX: 0,
                    movementY: 0
                },
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
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
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
           
            getRelativeCoords(x, y) {
                console.log('x ir', x);
                console.log('y ir',y);
                this.cordsArr.push({x,y})
                //this.shout(this.cordsArr);
              //  <button v-on:click="saveCoords()">SAVE Coordinates</button>
            },

            saveCoords(x, y){
                console.log('xxx ir', x);
                console.log('y yy ir',y);
                this.shout(this.cordsArr);
            },
    dragMouseDown(event) {
                event.preventDefault();
                // get the mouse cursor position at startup:
                this.positions.clientX = event.clientX;
                this.positions.clientY = event.clientY;
                document.onmousemove = this.elementDrag;
                document.onmouseup = this.closeDragElement;
            },
            elementDrag(event) {
                event.preventDefault();
                this.positions.movementX = this.positions.clientX - event.clientX;
                this.positions.movementY = this.positions.clientY - event.clientY;
                this.positions.clientX = event.clientX;
                this.positions.clientY = event.clientY;
                // set the element's new position:
                this.$refs.draggableContainer.style.top = (this.$refs.draggableContainer.offsetTop - this.positions.movementY) + 'px';
                this.$refs.draggableContainer.style.left = (this.$refs.draggableContainer.offsetLeft - this.positions.movementX) + 'px';
            },
            closeDragElement () {
                document.onmouseup = null;
                document.onmousemove = null;
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
        .canvas-test{
            padding: 0;
            margin: auto;
            display: block;
             
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
        .circle{
            width:30px;
            height: 30px;
            border-radius:50%;
            background-color:red;
        }

        #draggable-container {
            position: absolute;
            z-index: 9;
        }
        #draggable-header {
            z-index: 10;
        }
    }

</style>