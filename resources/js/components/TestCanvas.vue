/* eslint-disable no-unused-vars */
<template>
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
        <div class="buttonDiv">
            <div class="Buttons">
                <button class="button" @click="addHomePlayer">Add HOME player!</button>
                <button class="button" @click="removeHomePlayer">Remove HOME player!</button>
            </div>
            <div class="Buttons">
                <button class="button" @click="addAwayPlayer">Add AWAY player!</button>
                <button class="button" @click="removeAwayPlayer">Remove AWAY player!</button>
            </div>
        </div>
        <v-stage class="stage"
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
                    fillEnabled: true,
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
                        fill: '#89b717',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,

                        dragBoundFunc: function (pos){
                            y1 =  pos.y < 10 ? 10 :pos.y && pos.y > 490 ? 490 :pos.y;
                            x1 = pos.x < 0 ? 10 :pos.x && pos.x >990 ? 990 :pos.x;
                            return{
                                x: x1,
                                y: y1,
                                
                            };
                        },
                    }"
                ></v-circle>
            </v-layer>
        </v-stage>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
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
                counter: 0,
                id_preset: 56,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],


                list: [],
                dragItemId: null,
                configKonva: {
                    width: 1000,
                    height: 500, 
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
                // save drag element:
                this.dragItemId = e.target.id();
                // move current element to the top:
                const item = this.list.find(i => i.id === this.dragItemId);
                const index = this.list.indexOf(item);
                this.list.splice(index, 1);
                this.list.push(item);
                this.shoutout("Drag started from ", item.x, item.y);
            },
            handleDragend(e) {
                this.dragItemId = e.target.id();
                const item = this.list.find(i => i.id == this.dragItemId);
                item.x = e.target.x();
                item.y = e.target.y();
                this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                this.dragItemId = null;
            },
            // eslint-disable-next-line no-unused-vars
            addHomePlayer(e){
                this.list.push({
                    id: this.count.toString(),
                    x: 175,
                    y: 30,
                    scale: 1
                });
                this.count++;
                this.shoutout("List data ",this.list);
                
            },
            // eslint-disable-next-line no-unused-vars
            removeHomePlayer(e){
                const index = this.count-1;
                if(index <0){ return; }
                this.shoutout("Deleted: ",index);
                this.list.splice(index, 1);
                this.count--;
                if(this.count <= 0){
                    this.count = 0;
                }
            },
            
            addAwayPlayer(e){
                this.list.push({
                    id: this.count.toString(),
                    x: 600,
                    y: 30,
                    scale: 1
                });
                this.count++;
                this.shoutout("List data ",this.list);
                
            },

            removeAwayPlayer(e){
                const index = this.count-1;
                if(index <0){ return; }
                this.shoutout("Deleted: ",index);
                this.list.splice(index, 1);
                this.count--;
                if(this.count <= 0){
                    this.count = 0;
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

        .stage{
            margin-left:20%;
            margin-top:1%;
        }

        .buttonDiv{
            display:table;
            margin-top:2%;
            margin-left:23%;
        }

        .Buttons{
            display:table-cell;
            width: 40%;
        }

        .button{
            margin-top:20%;
            display:inline-block;
            padding:0.3em 1.2em;
            margin:0 0.3em 0.3em 0;
            border-radius:2em;
            box-sizing: border-box;
            text-decoration:none;
            font-family:'Roboto',sans-serif;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1db40f;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }
    }

</style>