/* eslint-disable no-unused-vars */
<template>
<!-- tatad, eror ir taja ka vienam ir list un otram list1, jaizdoma ka tur ielikt if, kurs pasaka kuru listu skatities(japadod kadam home vertiba).  
un erors ir taja, ka peivono klat un nonem un atkal vieno klat, tad duble id  -->
    <div id="canvasTest">
        <!-- <div>
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
        <button v-on:click.once="drawItem(0, 0, 130)">Draw item 0</button> -->
        <v-stage class="stageYes"
            ref="stage"
            :config="configKonva"
            @dragstart="handleDragstart"
            @dragend="handleDragend"
            @mousemove="testingCoords"
        >
            <v-layer ref="layer">
                <v-image :config="{
                    width: configKonva.width,
                    height: configKonva.height,
                    image: img,
                    listening: false,
                }"/>
                <v-circle
                    v-for="item in list"
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: '#89fbcf',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        player: item.player,
                    }"
                    
                ></v-circle>
                 <v-circle
                    v-for="item in list1"
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: '#89baa7',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        player: item.player,
                    }"
                    
                ></v-circle>
               
            </v-layer>
        </v-stage>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        <button @click="addHome">Add home players!</button>
        <button @click="removeHome">Remove home Players</button>
        <button @click="addAway">Add away players!</button>
        <button @click="removeAway">Remove away players</button>
    </div>
</template>

<script>
    const width = window.innerWidth;
    const height = window.innerHeight;
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
                counter: 0,
                id_preset: 69,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],
                list1: [],
                list: [],
                player: null,
                dragItemId: null,
                configKonva: {
                    width: 1000,
                    height: 500,
                    
                },
                configCircle: {//vai so mumns vispar vajag?
                    x: 40,
                    y: 40,
                    radius: 20,
                    fill: "red",
                    stroke: "black",
                    strokeWidth: 4,
                    draggable: true,
                },
                count : 0,
            }
        },
        mounted(){//starts up with loading of the page
            // console.log("Izsaucas mounted");
            // this.canvas = document.getElementById("canv");
            // this.context = this.canvas.getContext('2d');
            // for (let n = 0; n < 5; n++) {
            //     this.list.push({
            //         id: Math.round(Math.random() * 10000).toString(),
            //         x: Math.random() * 1000,
            //         y: Math.random() * 500,
            //         rotation: Math.random() * 180,
            //         scale: 1
            //     });
            // }
        },
       
       
        methods: { 
            async getData(){
                const {data} = await sampleRequest.getSportsTypes({ id:this.id_preset});
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
                this.img = new window.Image();
                this.img.src = this.image;
                this.img.onload = () => {
                    // set image only when it is loaded
                };
            },
            handleDragstart(e) {
                this.dragItemId = e.target.id();
                // move current element to the top:
                const item = this.list1.find(i => i.id === this.dragItemId);
                const index = this.list1.indexOf(item);
                this.player = item.player;
                console.log('player: ',this.player);
                if(this.player === 'home'){
                    this.list.splice(index, 1);
                    this.list.push(item);
                    this.shoutout("Drag started from ", item.x, item.y);
                    this.player = null;
                }else{
                    const item = this.list1.find(i => i.id === this.dragItemId);
                    const index = this.list1.indexOf(item);
                    console.log("this is awway");
                    this.list1.splice(index, 1);
                    this.list1.push(item);
                    this.shoutout("Drag started from ", item.x, item.y);
                    this.player = null;
                }
                // save drag element:
                
            },
            // handleDragstartAway(e) {
            //     // save drag element:
            //     this.dragItemId = e.target.id();
            //     // move current element to the top:
            //     const item = this.list1.find(i => i.id === this.dragItemId);
            //     const index1 = this.list1.indexOf(item);
            //     this.list1.splice(index1, 1);
            //     this.list1.push(item);
            //     this.shoutout("Drag started from ", item.x, item.y);
                
            // },
            handleDragend(e) {
                this.dragItemId = e.target.id();
                const item = this.list1.find(i => i.id == this.dragItemId);
                this.player = item.player;
                console.log('player: ',this.player);
                if(this.player === 'home'){
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemId = null;
                }else{
                    this.dragItemId = e.target.id();
                    const item = this.list1.find(i => i.id == this.dragItemId);
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemId = null;
                }
                
            },
            // handleDragendAway(e) {
            //     this.dragItemId = e.target.id();
            //     const item = this.list1.find(i => i.id == this.dragItemId);
            //     item.x = e.target.x();
            //     item.y = e.target.y();
            //     this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
            //     this.dragItemId = null;
            // },
            addHome(e){
                this.list.push({
                    id: this.count.toString(),
                    x: 175,
                    y: 30,
                    player: 'home',
                    scale: 1,
                });
                this.count++;
                this.shoutout("List data ",this.list);
                
            },
            addAway(e){
                this.list1.push({
                    id: this.count.toString(),
                    x: 825,
                    y: 30,
                    player: 'away',
                    scale: 1,
                });
                this.count++;
                this.shoutout("List1 data ",this.list1);
                
            },
            removeHome(e){//japieliek klat player home or away
                const index = this.count-1;
                if(index <0){ return; }
                this.shoutout("Deleted: ",index);
                this.list.splice(index, 1);
                this.count--;
                if(this.count <= 0){
                    this.count = 0;
                }
            },
            removeAway(e){
                const index = this.count-1;
                if(index <0){ return; }
                this.shoutout("Deleted: ",index);
                this.list1.splice(index, 1);
                this.count--;
                if(this.count <= 0){
                    this.count = 0;
                }
            },
            drawItem(index, x, y) {//draws the picture
                console.log('args:', index, x, y);
                this.img = new Image();
                this.img.src = this.image;
                console.log('this.image:', this.image);
                this.img.onload = () => {
                    console.log('this.ctx:', this.context);
                    this.context.drawImage(this.img, x, y);
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
            testingCoords(){
                let stage = this.$refs.stage.getStage();
                var pos = stage.getPointerPosition();
                // console.log(pos);
                // var stageAttrs = stage.attrs;
                // console.log(stageAttrs);
                var x = pos.x;
                var y = pos.y;
                this.xpoint = x;
                this.ypoint = y;
                // console.log("Coords: ",x,y);
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
        // .stage{
        //     background-color:blue;
        // }
        .layer{
            background-color: rgb(23, 238, 23);
        }
        .stageYes{
            margin-left: 10%;
            margin-top: 10%;
        }
    }

</style>