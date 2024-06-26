const os = require('os')
console.log(os.uptime())
const Osinfor={
    osname:os.type(),
    release:os.release(),
    totalmem:os.totalmem(),
    freemem:os.freemem(),
}
console.log(Osinfor)