import axios from 'axios'
export default {
    videos:function(){
        axios.get('http://casteaching.test/api/videos').then(function (data){
            console.log(data);
        }).catch(function (error){
            console.log(error);
        })
    }
}
