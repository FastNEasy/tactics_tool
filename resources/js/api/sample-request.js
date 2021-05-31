import request from '@/utility/request';
//import { post } from 'jquery';
// import Resource from '@/api/resource';

// class ExampleApi extends Resource {
class ExampleApi {
  constructor(endPoint) {
    this.uri = 'api/example-api' + (endPoint ? `/${endPoint}` : "");//inline ifs (if ? true : else)

    /** When is extended. */
    // super('production');
  }

  doRequest(data){
    // return request({
    //   url: '/' + this.uri + '/do-request',
    //   /** For GET request params go under... well... 'params' */
    //   method: 'get',
    //   params: data,
    //   /** For POST request params go under 'data' */
    // //   method: 'post',
    // //   data: data,
    // });
    return data;
  }
  saveSportsType(data){
      return request({
        url: '/' + this.uri + '/save-sports-type',
        /** For POST request params go under 'data' */
        method: 'post',
        data: data,
      });
  }
  saveTacticName(data){
    return request({
      url: '/' + this.uri + '/save-tactics-name',
      method: 'post',
      data: data,
    });
  }
}

export { ExampleApi as default };