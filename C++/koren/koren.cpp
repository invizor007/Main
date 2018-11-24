#include <iostream.h>

using namespace std;

float a,b;

float f(float x)
{
      return x*x-0.5;
}

float fs(float x)
{
      return 2*x;
}
/*
int need_new()
{
     return sgn(f(a)*f(b));
}
*/
void apply_new(float c)
{
     if (f(c)*f(a)>=0) a=c;
     if (f(c)*f(a)<=0) b=c;
}

void make_start()
{
     a=0;b=1;     
}

float new_popolam()
{
      return (a+b)/2;
}

float new_seku()
{
      return (a*f(b)-b*f(a))/(f(b)-f(a));
}

float new_kasat()
{
      return b-(f(b)/fs(b));
}

float seku()
{
      int count=5;
      make_start();
      for (int i=0;(i<count)&&(a!=b);i++)
               {apply_new(new_seku());
               cout<<"a="<<a<<" b="<<b<<endl;}
      return new_seku();
}

float popolam()
{
      int count=5;
      make_start();
      for (int i=0;(i<count)&&(a!=b);i++)
               {apply_new(new_popolam());
               cout<<"a="<<a<<" b="<<b<<endl;}
      return new_popolam();
}

float kasat()
{
      int count=5;
      make_start();
      for (int i=0;(i<count)&&(a!=b);i++)
               {apply_new(new_kasat());
               cout<<"a="<<a<<" b="<<b<<endl;}
      return new_popolam();
}

int main()
{    
    cout<<"popolam="<<popolam()<<endl;
    cout<<"seku="<<seku()<<endl;
    cout<<"kasat="<<kasat()<<endl;
    getchar();
    return 0;
}
