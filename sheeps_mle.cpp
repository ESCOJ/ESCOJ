#include<iostream>
#include<algorithm>
#include<vector>
std::vector<int>nums;
std::vector<int>::iterator pos;
int n,x;
int a[10000002];
int c[10000002];
int b[10000002];
int d[10000002];
int e[10000002];
int f[10000002];
int g[10000002];
int h[10000002];
int i[10000002];

int j[10000002];
int k[10000002];
int l[10000002];
int m[10000002];
int nn[10000002];
int o[10000002];
int p[10000002];
int q[10000002];
int r[10000002];
int main(){
	std::cin>>n;
	a[10000000] = 100;
	b[10000000] = 100;
	c[10000000] = 100;
	d[10000000] = 100;
	e[10000000] = 100;
	f[10000000] = 100;
	g[10000000] = 100;
	h[10000000] = 100;
	i[10000000] = 100;
	j[10000002] = 100;
	k[10000002] = 100;
	l[10000002] = 100;
	m[10000002] = 100;
	nn[10000002] = 100;
	o[10000002] = 100;
	p[10000002] = 100;
	q[10000002] = 100;
	r[10000002] = 100;
	
	for(int i=0;i<n;i++){
		std::cin>>x;
		nums.push_back(x);
	}
	std::cin>>x;
	pos = std::lower_bound(nums.begin(),nums.end(),x);
	(nums[pos - nums.begin()] == x) ? std::cout<<"True\n":std::cout<<"False\n";
	return 0;
}