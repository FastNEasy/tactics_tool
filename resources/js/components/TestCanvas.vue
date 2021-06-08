<template>
    <div id="canvasTest">
        <!-- <canvas id="canv" class="canvas-test" ></canvas> -->
        <!-- <button @click="drawRect()">Add Rect</button> -->
        <div>
            <!-- <button id="dragItem" draggable="true">You can drag me!</button> -->
            <canvas
                @mousemove="updateCoords" 
                @mousedown="getCoords"
                id="canv" class="canvas-test" width="1080" height="680" >
            </canvas>
            <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        </div>
        <div ref="draggableContainer" id="draggable-container">
            <div id="circle" class="circle" @mousedown="dragMouseDown"></div>    
        </div>
        <button v-on:click="drawItem(0, 0, 100)">Draw item 0</button>
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
                x1: 0,
                y1: 0,
                // x2: 0,
                // y2: 0,
                counter: 0,
                id: 69,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],
                positions:{
                    clientX:undefined,
                    clientY:undefined,
                    movementX: 0,
                    movementY: 0
                },
            }
        },
        mounted(){//starts up with loading of the page
            console.log("Izsaucas mounted");
            this.canvas = document.getElementById("canv");
            this.context = this.canvas.getContext('2d');
        },
       
       
        methods: { 
            async getData(){
                const {data} = await sampleRequest.getSportsTypes({ id:this.id});
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
            },
            drawItem(index, x, y) {//draws the picture
                console.log('args:', index, x, y);
                this.img = new Image();
                this.img.src = this.image;
                console.log('this.image:', this.image);
                this.img.onload = () => {
                    console.log('this.ctx:', this.canvas);
                    this.canvas.drawImage(this.img, x, y);
                }
            },
            drawLine(x1, y1, x2, y2) {
                let ctx = this.context;
                ctx.beginPath();
                ctx.strokeStyle = 'black';
                ctx.lineWidth = 1;
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.closePath();
            },

            dragMouseDown: function (event) {
                event.preventDefault();
                // get the mouse cursor position at startup:
                this.positions.clientX = event.clientX;
                this.positions.clientY = event.clientY;
                document.onmousemove = this.elementDrag;
                document.onmouseup = this.closeDragElement;
            },
            elementDrag: function (event) {
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
            getCoords(event){//translates coordinates for the canvas
                this.x1 = event.clientX;
                this.y1 = event.clientY;
                this.shoutout("Gotten x and y: ",this.x1,this.y1);
                var rect = event.target.getBoundingClientRect();
                this.shout(rect);
                this.translateCoords(rect, event.clientX, event.clientY);
                this.coords.push({ x: this.x1, y: this.y1 });
                this.counter++;
                if(this.counter == 2){
                    this.drawLine(this.coords[0].x,this.coords[0].y, this.coords[1].x,this.coords[1].y);
                    this.counter = 0;
                    this.shout(this.coords);
                    this.coords.splice(0);
                }
            },
            translateCoords(rect, x, y){
                var factor = 1080 / rect.width;
                this.shout(factor);
                this.x1 = factor * (x - rect.left);
                this.y1 = factor * (y - rect.top);
                this.shoutout("New x and y: ",this.x1,this.y1);
            },
            updateCoords(event){
                this.xpoint = event.clientX;
                this.ypoint = event.clientY;
            },
            // handleMouseDown(e) {
               
            // },
            // handleMouseUp(e) {

            // },
            // // also done dragging
            // handleMouseOut(e) {
               
            // },
            // handleMouseMove(e) {
               
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
            width:40px;
            height: 40px;
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