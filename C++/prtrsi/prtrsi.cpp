#include <iostream.h>

using namespace std;

float f(float x)
{
      return x*x;
}

float a=0,b=1;
const int n=10;
float t[2*n+1];

int main()
{
    int i;
    float res;
    float d2=(b-a)/(2*n);
    
    for (i=0;i<=2*n;i++) t[i]=a+i*d2;
    //pryamoug
    res=0;
    for (i=0;i<n;i++) res+=f(t[2*i+1])*2*d2;
    cout<<"pryamougolniki="<<res<<endl;
    //trapecii
    res=0;
    for (i=0;i<n;i++) res+=( f(t[2*i])+f(t[2*i+2]) )*d2;
    cout<<"trapecii="<<res<<endl;
    //simpson
    res=0;
    for (i=0;i<n;i++) res+=( f(t[2*i])+4*f(t[2*i+1])+f(t[2*i+2]) )*d2/3;
    cout<<"simpson="<<res<<endl;
    getchar();
    return 0;
}
