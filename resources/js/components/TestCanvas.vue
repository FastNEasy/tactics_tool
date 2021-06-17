/* eslint-disable no-unused-vars */
<template>
    <div id="canvasTest">
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
            @mousemove="displayCords"
        >
            <v-layer ref="layer">
                <v-image :config="{
                    width: configKonva.width,
                    height: configKonva.height,
                    image: img,
                    listening: false,
                    fillEnabled: true,
                }"/>
            </v-layer>
        </v-stage>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        <!-- <button @click="addPlayer">Add a player</button>
        <button @click="removePlayer">Remove a player</button>
        <button @click="lockCords">Lock in Cords!</button> -->
        <button @click="animInit">Test!</button>
        <button @click="setCords">Lock coordinates!</button>
        <!-- <button @click="addPlayerHome">Add Player test2</button> -->
    </div>
</template>

<script>
    import Konva from "konva";
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
                id_preset: 23,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                // coords: [],
                listHome: [],
                listAway: [],
                dragItemAwayId: null,
                dragItemHomeId: null,
                delItemHomeId: null,
                delItemAwayId: null,
                setItemCords: null,
                configKonva: {
                    width: 1000,
                    height: 500,
                },
                countHome : 0,
                countAway : 0,
                countRow2 : 0,
                countRow : 0,
                changeHomeX : 175,
                changeHomeY : 30,
                changeAwayX: 950,
                changeAwayY: 30,
                iter: null,
                lock: [],
                setUp: 0,
                count2: 0,
                choiceId: null,
                isPlaying: 0,
                circle: null,
                cnt: 0,
                listHomePlayers: [],
                listAwayPlayers: [],
                identy: null,
                handledPlayersHome: [],
                handledPlayersAway: [],
                count_times: 0,
                played: false,
            }
        },
        mounted(){},
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
            handleDragstart(e){//drag handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.shoutout("The chosen home player is: ", this.choiceId);
                    this.dragItemHomeId = e.target.id();
                    this.shoutout("dragItemHomeId", this.dragItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const circle = this.listHomePlayers.find(i => i.id === this.dragItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    this.shoutout("Circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    // item.preCords.push({x: this.x1,y:this.y1});
                    this.listHome.splice(index, 1);
                    this.listHome.push(item);
                    this.listHomePlayers.splice(index2, 1);
                    this.listHomePlayers.push(circle);

                }else{
                    this.shoutout("Chosen away player: ", this.choiceId);
                    this.dragItemAwayId = e.target.id();
                    this.shoutout("dragItemAwayId ", this.dragItemAwayId);
                    const item = this.listAway.find(i => i.id === this.dragItemAwayId);
                    const circle = this.listAwayPlayers.find(i => i.id === this.dragItemAwayId);
                    const index = this.listAway.indexOf(item);
                    const index2 = this.listAwayPlayers.indexOf(circle);
                    this.shoutout("circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1, this.y1);
                    this.listAway.splice(index, 1);
                    this.listAway.push(item);
                    this.listAwayPlayers.splice(index2, 1);
                    this.listAwayPlayers.push(circle);
                }
            },
            handleDragend(e){//drag end handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.dragItemHomeId = e.target.id();
                    this.delItemHomeId = this.dragItemHomeId;
                    if(this.handledPlayersHome.indexOf(this.delItemHomeId) < 0){//adds moved players to the list
                        console.log("It was not in the array!");
                        this.handledPlayersHome.push(this.delItemHomeId);
                    }
                    this.shoutout("delItemHomeId: ", this.delItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const circle = this.listHomePlayers.find(i => i.id === this.dragItemHomeId);
                    circle.circ.position({
                        x: e.target.x(),
                        y: e.target.y(),
                    });
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemHomeId = null;
                }else{
                    this.dragItemAwayId = e.target.id();
                    this.delItemAwayId = this.dragItemAwayId;
                    if(this.handledPlayersAway.indexOf(this.delItemAwayId) < 0){//adds moved players to the list
                        console.log("It was not in the array!");
                        this.handledPlayersAway.push(this.delItemAwayId);
                    }
                    this.shoutout("delItemAwayId: ", this.delItemAwayId);
                    const item = this.listAway.find(i => i.id === this.dragItemAwayId);
                    const circle = this.listAwayPlayers.find(i => i.id === this.dragItemAwayId);
                    circle.circ.position({
                        x: e.target.x(),
                        y: e.target.y(),
                    });
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemAwayId = null;
                }
            },
            setCords(e){//sets coordinates where you place them
                //TODO: make so that everyone gets a piece of cake
                this.shoutout(this.handledPlayersHome.length);
                if(this.handledPlayersHome.length > 0){
                    for (const playerId of this.handledPlayersHome) {
                        this.shoutout("In loop this id: ", playerId);
                        const item = this.listHome.find(i => i.id === playerId);
                        const player = this.listHomePlayers.find(i => i.id === playerId);
                        if(item.y == 30){ continue; }
                        item.preCords.push({ x:item.x,y:item.y});
                        player.circ.position({
                            x: item.x,
                            y: item.y,
                        });
                        this.shoutout("current coords added: ",item.preCords);
                        this.shoutout(player.circ);
                        this.shoutout("the touched list of home players: ", this.handledPlayersHome);
                    }
                    this.shoutout("All Home players on the page coords set!");
                }else{
                    this.shoutout("None moved objects found");
                    return;
                }
                if(this.handledPlayersAway.length > 0){
                   for (const playerId of this.handledPlayersAway) {
                        this.shoutout("In loop this id: ", playerId);
                        const item = this.listAway.find(i => i.id === playerId);
                        const player = this.listAwayPlayers.find(i => i.id === playerId);
                        if(item.y == 30){ continue; }
                        item.preCords.push({ x:item.x,y:item.y});
                        player.circ.position({
                            x: item.x,
                            y: item.y,
                        });
                        this.shoutout("current coords added: ",item.preCords);
                        this.shoutout(player.circ);
                        this.shoutout("the touched list of away players: ", this.handledPlayersAway);
                    }
                    this.shoutout("All Away players on the page coords set!");
                }else{
                    this.shoutout("None moved objects found");
                    return;
                }
            },
            addHomePlayer(e){//adds new player object and circle  to the stage
                this.shoutout("COUNT:", this.countHome);
                if(this.countHome == 6){ return; }
                this.changeHomeX += 40;
                this.identy = 'Home_'+this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.countHome);
                // this.handledPlayersHome.push(this.identy);
                this.listHome.push({
                    id: this.identy,
                    x: this.changeHomeX,
                    y: this.changeHomeY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listHome.find(i => i.id === this.identy);
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: '#89b717',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listHomePlayers.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listHomePlayers);
                this.countHome++;
                this.countRow++;
                if(this.countRow == 6){ this.changeHomeY+=40; this.changeHomeX = 175; this.countRow = 0; }
                this.shoutout("COUNT: ", this.countHome);
            },
            addAwayPlayer(e){
                this.shoutout("COUNT: ", this.countAway);
                if(this.countAway == 6){ return; }
                this.changeAwayX -=40;
                this.identy = 'Away_'+ this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.countAway);
                this.listAway.push({
                    id: this.identy,
                    x: this.changeAwayX,
                    y: this.changeAwayY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listAway.find(i => i.id === this.identy);
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: 'red',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemAwayId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemAwayId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listAwayPlayers.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listAwayPlayers);
                this.countAway++;
                this.countRow2++;
                if(this.countRow2 == 6){ this.changeAwayY+=40; this.changeAwayX = 950; this.countRow2 = 0; }
                this.shoutout("COUNT: ", this.countAway);
            },
            removeHomePlayer(e){//removes circle and everything considering the player
                if(this.delItemHomeId != null){
                    const item = this.listHome.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Item: ",item);
                    const circle = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.delItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    const index3 = this.handledPlayersHome.indexOf(this.delItemHomeId);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.handledPlayersHome.splice(index3, 1);
                    this.listHomePlayers.splice(index2, 1);
                    this.listHome.splice(index, 1);
                    this.countHome--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.countHome);
                    if(this.countHome <= 0){
                        this.countHome = 0;
                    }
                    this.shoutout("Home List data ", this.listHome);
                    this.shoutout("Home circle data ", this.listHomePlayers)
                    this.delItemHomeId = null;
                }else{
                    return;
                }
            },
            removeAwayPlayer(e){
                if(this.delItemAwayId != null){
                    const item = this.listAway.find(i => i.id === this.delItemAwayId);
                    this.shoutout("Item: ",item);
                    const circle = this.listAwayPlayers.find(i => i.id === this.delItemAwayId);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.delItemAwayId);
                    const index = this.listAway.indexOf(item);
                    const index2 = this.listAwayPlayers.indexOf(circle);
                    const index3 = this.handledPlayersAway.indexOf(this.delItemAwayId);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.handledPlayersAway.splice(index3, 1);
                    this.listAwayPlayers.splice(index2, 1);
                    this.listAway.splice(index, 1);
                    this.countAway--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.countAway);
                    if(this.countAway <= 0){
                        this.countAway = 0;
                    }
                    this.shoutout("Home List data ", this.listAway);
                    this.shoutout("Home circle data ", this.listAwayPlayers)
                    this.delItemAwayId = null;
                }else{
                    return;
                }
            },
            displayCords(){
                let stage = this.$refs.stage.getStage();
                var pos = stage.getPointerPosition();
                var x = pos.x;
                var y = pos.y;
                this.xpoint = x;
                this.ypoint = y;
            },
            rndStr(len) {
                let text = "";
                let chars = "abcdefghijklmnopqrstuvwxyz";
                for( let i=0; i < len; i++ ) {
                    text += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return text;
            },
            animInit(e){
                for (const idplayer of this.handledPlayersHome) {
                    var i = 1;
                    const item = this.listHome.find(i => i.id === idplayer);
                    const player = this.listHomePlayers.find(i => i.id === idplayer);
                    player.circ.position({
                        x: item.preCords[0].x,
                        y: item.preCords[0].y,
                    });
                    this.animPlay(item, player.circ, i);
                }
                for(const idplayer2 of this.handledPlayersAway){
                    var j = 1;
                    const item2 = this.listAway.find(i => i.id === idplayer2);
                    const player2 = this.listAwayPlayers.find(i => i.id === idplayer2);
                    player2.circ.position({
                        x: item2.preCords[0].x,
                        y: item2.preCords[0].y,
                    });
                    this.animPlay(item2, player2.circ, j);
                }
                return;
            },
            animPlay(item,player,i){
                var tween = new Konva.Tween({
                    node: player,
                    duration: 1,
                    x: item.preCords[i].x,
                    y: item.preCords[i].y,
                    onUpdate: () => console.log("first tween updated"),
                    onFinish: () => {
                        console.log("first tween ended");
                        if(item.preCords[i+1]!= null){
                            player.position({
                                x: item.preCords[i].x,
                                y: item.preCords[i].y,
                            });
                            i++;
                            this.animPlay(item,player,i);
                        }
                    },
                });
                tween.play();
            },
            // handleDragend(e) {//change the save coordinates of the player when the drag ends
            //     this.choiceId = e.target.id();
            //     if(this.choiceId.includes('Home_')){
            //         this.dragItemHomeId = e.target.id();//get the dragged player id
            //         this.delItemHomeId = this.dragItemHomeId;
            //         const item = this.listHome.find(i => i.id === this.dragItemHomeId);
            //         item.x = e.target.x();
            //         item.y = e.target.y();
            //         // item.preCords.splice(1,1);
            //         this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
            //         this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
            //         this.dragItemHomeId = null;
            //     }else{
            //         this.dragItemAwayId = e.target.id();
            //         this.delItemAwayId = this.dragItemAwayId;
            //         const item = this.listAway.find(i => i.id == this.dragItemAwayId);
            //         item.x = e.target.x();
            //         item.y = e.target.y();
            //         this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
            //         this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
            //         this.dragItemAwayId = null;
            //     }    
            // },
            // handleDragstart(e) {//starts to see which player is dragged and uses it respectivly
            //     // save drag element:
            //     this.choiceId = e.target.id();
            //     if(this.choiceId.includes('Home_')){
            //         this.shoutout("The chosen one is: ",this.choiceId);
            //         this.dragItemHomeId = e.target.id();
            //         // move current element to the top:
            //         const item = this.listHome.find(i => i.id === this.dragItemHomeId);
            //         const index = this.listHome.indexOf(item);
            //         this.x1 = item.x;
            //         this.y1 = item.y;
            //         this.shoutout(this.x1,this.y1);
            //         item.preCords.push({x: this.x1, y:this.y1});
            //         // console.log(index);
            //         this.listHome.splice(index, 1);
            //         this.listHome.push(item);
            //         this.shoutout("Drag started from ", item.x, item.y);
            //     } else{
            //         this.dragItemAwayId = e.target.id();
            //         const item = this.listAway.find(i => i.id === this.dragItemAwayId);
            //         const index = this.listAway.indexOf(item);
            //         this.x1 = item.x;
            //         this.y1 = item.y;
            //         this.shoutout(this.x1,this.y1);
            //         item.preCords.push({x: this.x1, y: this.y1});
            //         this.listAway.splice(index, 1);
            //         this.listAway.push(item);
            //         this.shoutout("Drag started: ", item.x, item.y);
            //     }
            // },
            // addHomePlayer(e){//adds new player object at the top of the field
            //     if(this.count == 6){ return}
            //     this.changeHomeX += 40;
            //     this.listHome.push({
            //         id: 'Home_'+this.count.toString(),
            //         x: this.changeHomeX,
            //         y: 30,
            //         preCords: [],
            //         scale: 1
            //     });
            //     this.count++;
            //     this.shoutout("List data ",this.listHome);
            // },
            // removeHomePlayer(e){//removes last added player object
            //     var check = this.count-1;
            //     if(check <0){ return; }
            //     console.log("check: ",this.delItemHomeId);
            //     const item = this.listHome.find(i => i.id === this.delItemHomeId);
            //     this.shoutout("Item: ",item);
            //     const index = this.listHome.indexOf(item);
            //     this.shoutout("Deleted: ",index);
            //     this.listHome.splice(index, 1);
            //     this.count--;
            //     this.changeHomeX-=40;
            //     if(this.count <= 0){
            //         this.count = 0;
            //     }
            //     this.shoutout("Home List data ", this.listHome);
            //     this.delItemHomeId = null;
            // },
                    //list.splice(start-1); nogrieziis visas koordinates iznemot pedejo
                    //ielikt listaa vecaas koordinates atbilstosham id, lai izveidotu pattern for animation
                    //just continue adding coords to the table
                    //pectam izveidojot animaciju, padot shos listus ,lai ar tiem darbotos

            // addAwayPlayer(e){
            //     if(this.count2 == 6){ return; }
            //     this.changeAwayX -= 40;
            //     this.listAway.push({
            //         id: 'Away_'+this.count2.toString(),
            //         x: this.changeAwayX,
            //         y: 30,
            //         preCords: [],
            //         scale: 1
            //     });
            //     this.count2++;
            //     this.shoutout("List data ",this.listAway);
            // },
            // removeAwayPlayer(e){
            //     var check = this.count2-1;
            //     if(check < 0){ return; }
            //     console.log("check: ", this.delItemAwayId);
            //     const item = this.listAway.find(i => i.id === this.delItemAwayId);
            //     this.shoutout("Item: ", item);
            //     const index = this.listAway.indexOf(item);
            //     this.shoutout("Deleted: ",index);
            //     this.listAway.splice(index, 1);
            //     this.count2--;
            //     this.changeAwayX+=40;
            //     if(this.count2 <= 0){
            //         this.count2 = 0;
            //     }
            //     this.shoutout("Away List data: ", this.listAway);
            //     this.delItemAwayId = null;
            // },
            // updateCoords(event){
            //     this.xpoint = event.clientX;
            //     this.ypoint = event.clientY;
            // },
            // replayAnim(){
            //     let moveHome = this.listHome.find(i => i.id === this.delItemHomeId);
            //     let moveAway = this.listAway.find(i => i.id === this.delItemAwayId);
            //     var turnAroun1 = false;
            //     var turnAroun2 = false;
            //     this.shoutout(moveHome);
            //     this.shoutout(moveAway);
            //     let amplitude = 5;
            //     var velocity = 50;
            //     var anim = new Konva.Animation(function (frame) {
            //         if(turnAroun1){
            //             moveHome.x -= (velocity * (50/ 1000));
            //             if(moveHome.x <= 20){
            //                 turnAroun1 = false;
            //             }
            //         }else if(moveHome.x >= 980){
            //             turnAroun1 = true;
            //         }else{
            //             moveHome.x += (velocity * (50/ 1000));
            //             moveHome.y += amplitude * Math.sin((frame.time * 2 * Math.PI) / 1000);
            //         }
            //         if(turnAroun2){
            //             moveAway.x += (velocity * (50/ 1000));
            //             if(moveAway.x >= 980){
            //                 turnAroun2 = false;
            //             }
            //         }else if(moveAway.x <= 20){
            //             turnAroun2 = true;
            //         }else{
            //             moveAway.x -= (velocity * (50/1000));
            //             moveAway.y += amplitude * Math.sin((frame.time * 2 * Math.PI)/1000);
            //         }  
            //     }, this.$refs.layer.getNode());
            //     anim.start();
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