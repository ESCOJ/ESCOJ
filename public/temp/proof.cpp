#include<bits/stdc++.h>
using namespace std;
vector<int> v;
int f(int a){
	return f(a);
}
int main(){
	/* PROOF 1
	int m[3002];
	for(int i=0;i<6000;i++)
		m[i] = i;
	*/

	/* PROOF 2
	int a = 5345;
	int c = 200;
	int b = 5545,m = 0;
	float d = 1234;
	float e = 0;
	for(int i=0;i<2;i++){
		if(i==1){
			b-=c;
			a-=b;
		}
		m++;
	}
	e = (d/a);*/

	/* PROOF 3
	for(;;){
		v.push_back(1);
	}*/

	///* PROOF 4
	int j = f(2);
	
	//*/
	return 0;
}

