import BaseReception from "./BaseReception";
export default class Reception implements BaseReception {
    id: number;
    name: string;
    constructor(p__id: number, p__name: string) {
        this.id = p__id;
        this.name = p__name;
    }
}
