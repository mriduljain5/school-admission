export interface HttpResponse<T> {
  status: number;
  data: T;
}

export interface SchoolList {
  school_name: string;
  school_board: string;
  school_medium: string;
  school_address: string;
}
