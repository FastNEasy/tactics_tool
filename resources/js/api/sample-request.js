import request from '@/utility/request';

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

  saveTactic(data){
    return request({
      url: '/' + this.uri + '/save-tactic',
      method: 'post',
      data: data,
    });
  }
  
  getSportsTypes(data){
    return request({
      url: '/' + this.uri + '/display-sport',
      method: 'get',
      data: data,
    });
  }

  getTacticName(data){
    return request({
      url: '/' + this.uri + '/display-tactic-name',
      method: 'get',
      data: data,
    });
  }
  deleteSportsTypes(data){
    return request({
      url: '/' + this.uri + '/delete-sport',
      method: 'post',
      data: data,
    });
  }

  deleteTacticName(data){
    return request({
      url: '/' + this.uri + '/delete-tactic',
      method: 'post',
      data: data,
    });
  }
  updateSportsType(data){
    return request({
      url: '/' + this.uri + '/update-sports-type',
      /** For POST request params go under 'data' */
      method: 'post',
      data: data,
    });
}
saveBase64(data){
  return request({
    url: '/' + this.uri + '/save-base64',
    /** For POST request params go under 'data' */
    method: 'post',
    data: data,
  });
}
}

export { ExampleApi as default };