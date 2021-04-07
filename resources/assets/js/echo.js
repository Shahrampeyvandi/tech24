import Event from "./event";

Echo.join("chat")
    .here(users => {
        
        Event.$emit("users.here", users);
    })
    .joining(user => {
        console.log('joining')
        Event.$emit("users.joined", user);
    })
    .leaving(user => {
        console.log('lefting')
        Event.$emit("users.left", user);
    })
    .listen("MessageCreated", data => {
        Event.$emit("added_message", data.message);
    });
